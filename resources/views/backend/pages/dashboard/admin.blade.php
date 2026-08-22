@extends('backend.layouts.backend')

@section('title', 'Admin Dashboard')

@section('content')

    <section class="admin-dashboard">


        {{--=================================
        Dashboard Header
        =================================--}}
        <div class="dashboard-header">

            <div class="dashboard-header__content">

                <div class="dashboard-label">
                    Overview
                </div>

                <h1>
                    Admin Dashboard
                </h1>

                <p>
                    Manage your ecommerce and Smart Buy operations from one place.
                </p>

            </div>


            <div class="dashboard-date">

                <i class="ri-calendar-line"></i>

                <span>
                    August 15, 2026
                </span>

            </div>

        </div>


        {{--=================================
        Dashboard Statistics
        =================================--}}
        <div class="dashboard-stats">

            <div class="row g-3">


                {{-- Total Customers --}}
                <div class="col-xl-3 col-md-6">

                    <div class="stat-card">

                        <div class="stat-card__top">

                            <div class="stat-card__icon">

                                <i class="ri-user-add-line"></i>

                            </div>


                            <div class="stat-card__growth">

                                <i class="ri-arrow-up-line"></i>

                                <span>
                                    8.4%
                                </span>

                            </div>

                        </div>


                        <div class="stat-card__label">
                            Total Customers
                        </div>


                        <div class="stat-card__value">
                            1,248
                        </div>


                        <p class="stat-card__meta">
                            Compared to last month
                        </p>

                    </div>

                </div>


                {{-- Ecommerce Orders --}}
                <div class="col-xl-3 col-md-6">

                    <div class="stat-card">

                        <div class="stat-card__top">

                            <div class="stat-card__icon">

                                <i class="ri-shopping-bag-3-line"></i>

                            </div>


                            <div class="stat-card__growth">

                                <i class="ri-arrow-up-line"></i>

                                <span>
                                    12.5%
                                </span>

                            </div>

                        </div>


                        <div class="stat-card__label">
                            Ecommerce Orders
                        </div>


                        <div class="stat-card__value">
                            248
                        </div>


                        <p class="stat-card__meta">
                            18 pending orders
                        </p>

                    </div>

                </div>


                {{-- Smart Buy Requests --}}
                <div class="col-xl-3 col-md-6">

                    <div class="stat-card">

                        <div class="stat-card__top">

                            <div class="stat-card__icon stat-card__icon--yellow">

                                <i class="ri-global-line"></i>

                            </div>


                            <div class="stat-card__growth">

                                <i class="ri-arrow-up-line"></i>

                                <span>
                                    8.4%
                                </span>

                            </div>

                        </div>


                        <div class="stat-card__label">
                            Smart Buy Requests
                        </div>


                        <div class="stat-card__value">
                            36
                        </div>


                        <p class="stat-card__meta">
                            7 requests need review
                        </p>

                    </div>

                </div>


                {{-- Total Revenue --}}
                <div class="col-xl-3 col-md-6">

                    <div class="stat-card">

                        <div class="stat-card__top">

                            <div class="stat-card__icon stat-card__icon--green">

                                <i class="ri-money-dollar-circle-line"></i>

                            </div>


                            <div class="stat-card__growth">

                                <i class="ri-arrow-up-line"></i>

                                <span>
                                    15.2%
                                </span>

                            </div>

                        </div>


                        <div class="stat-card__label">
                            Total Revenue
                        </div>


                        <div class="stat-card__value">
                            $24,850
                        </div>


                        <p class="stat-card__meta">
                            Compared to last month
                        </p>

                    </div>

                </div>

            </div>

        </div>


        {{--=================================
        Operations Overview
        =================================--}}
        <div class="dashboard-section">


            <div class="dashboard-section__header">

                <div class="dashboard-section__title">

                    <h2>
                        Operations Overview
                    </h2>

                    <p>
                        Current ecommerce and Smart Buy activity.
                    </p>

                </div>

            </div>


            <div class="row g-3">


                {{-- Ecommerce Overview --}}
                <div class="col-lg-6">

                    <div class="dashboard-card">

                        <div class="dashboard-card__header">

                            <div class="dashboard-card__heading">

                                <div class="dashboard-card__icon">

                                    <i class="ri-store-2-line"></i>

                                </div>


                                <div class="dashboard-card__title">

                                    <h3>
                                        Ecommerce
                                    </h3>

                                    <p>
                                        Store operations
                                    </p>

                                </div>

                            </div>


                            <a
                                href="#"
                                class="dashboard-card__action"
                            >

                                <span>
                                    View
                                </span>

                                <i class="ri-arrow-right-line"></i>

                            </a>

                        </div>


                        <div class="operation-list">


                            <div class="operation-item">

                                <span class="operation-item__label">
                                    Total Orders
                                </span>

                                <strong class="operation-item__value">
                                    248
                                </strong>


                                <span class="operation-item__label">
                                    Pending Orders
                                </span>

                                <strong class="operation-item__value operation-item__value--warning">
                                    18
                                </strong>

                            </div>


                            <div class="operation-item">

                                <span class="operation-item__label">
                                    Active Shipments
                                </span>

                                <strong class="operation-item__value">
                                    42
                                </strong>


                                <span class="operation-item__label">
                                    Delivered
                                </span>

                                <strong class="operation-item__value operation-item__value--success">
                                    186
                                </strong>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- Smart Buy Overview --}}
                <div class="col-lg-6">

                    <div class="dashboard-card">

                        <div class="dashboard-card__header">

                            <div class="dashboard-card__heading">

                                <div class="dashboard-card__icon dashboard-card__icon--yellow">

                                    <i class="ri-global-line"></i>

                                </div>


                                <div class="dashboard-card__title">

                                    <h3>
                                        Smart Buy
                                    </h3>

                                    <p>
                                        Request operations
                                    </p>

                                </div>

                            </div>


                            <a
                                href="#"
                                class="dashboard-card__action"
                            >

                                <span>
                                    View
                                </span>

                                <i class="ri-arrow-right-line"></i>

                            </a>

                        </div>


                        <div class="operation-list">


                            <div class="operation-item">

                                <span class="operation-item__label">
                                    Total Requests
                                </span>

                                <strong class="operation-item__value">
                                    36
                                </strong>


                                <span class="operation-item__label">
                                    Need Review
                                </span>

                                <strong class="operation-item__value operation-item__value--warning">
                                    7
                                </strong>

                            </div>


                            <div class="operation-item">

                                <span class="operation-item__label">
                                    Pending Quotes
                                </span>

                                <strong class="operation-item__value">
                                    5
                                </strong>


                                <span class="operation-item__label">
                                    Active Shipments
                                </span>

                                <strong class="operation-item__value operation-item__value--success">
                                    18
                                </strong>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{--=================================
        Orders & Smart Buy Requests
        =================================--}}
        <div class="dashboard-section">

            <div class="row g-3">


                {{-- Recent Ecommerce Orders --}}
                <div class="col-xl-7">

                    <div class="dashboard-card">

                        <div class="dashboard-card__header">

                            <div class="dashboard-card__title">

                                <h3>
                                    Recent Ecommerce Orders
                                </h3>

                                <p>
                                    Latest customer orders.
                                </p>

                            </div>


                            <a
                                href="#"
                                class="dashboard-card__action"
                            >

                                <span>
                                    View All
                                </span>

                                <i class="ri-arrow-right-line"></i>

                            </a>

                        </div>


                        <div class="table-responsive">

                            <table class="dashboard-table">

                                <thead>

                                <tr>

                                    <th>
                                        Order
                                    </th>

                                    <th>
                                        Customer
                                    </th>

                                    <th>
                                        Date
                                    </th>

                                    <th>
                                        Amount
                                    </th>

                                    <th>
                                        Status
                                    </th>

                                </tr>

                                </thead>


                                <tbody>


                                <tr>

                                    <td>

                                        <a
                                            href="#"
                                            class="order-id"
                                        >
                                            #BA-10248
                                        </a>

                                    </td>

                                    <td>
                                        Amadou Diallo
                                    </td>

                                    <td>
                                        Aug 15, 2026
                                    </td>

                                    <td>

                                            <span class="order-amount">
                                                $245.00
                                            </span>

                                    </td>

                                    <td>

                                            <span class="status-badge status-badge--completed">
                                                Completed
                                            </span>

                                    </td>

                                </tr>


                                <tr>

                                    <td>

                                        <a
                                            href="#"
                                            class="order-id"
                                        >
                                            #BA-10247
                                        </a>

                                    </td>

                                    <td>
                                        Mariama Camara
                                    </td>

                                    <td>
                                        Aug 15, 2026
                                    </td>

                                    <td>

                                            <span class="order-amount">
                                                $128.50
                                            </span>

                                    </td>

                                    <td>

                                            <span class="status-badge status-badge--processing">
                                                Processing
                                            </span>

                                    </td>

                                </tr>


                                <tr>

                                    <td>

                                        <a
                                            href="#"
                                            class="order-id"
                                        >
                                            #BA-10246
                                        </a>

                                    </td>

                                    <td>
                                        Ibrahima Bah
                                    </td>

                                    <td>
                                        Aug 14, 2026
                                    </td>

                                    <td>

                                            <span class="order-amount">
                                                $560.00
                                            </span>

                                    </td>

                                    <td>

                                            <span class="status-badge status-badge--shipped">
                                                Shipped
                                            </span>

                                    </td>

                                </tr>


                                <tr>

                                    <td>

                                        <a
                                            href="#"
                                            class="order-id"
                                        >
                                            #BA-10245
                                        </a>

                                    </td>

                                    <td>
                                        Fatoumata Sylla
                                    </td>

                                    <td>
                                        Aug 14, 2026
                                    </td>

                                    <td>

                                            <span class="order-amount">
                                                $89.00
                                            </span>

                                    </td>

                                    <td>

                                            <span class="status-badge status-badge--pending">
                                                Pending
                                            </span>

                                    </td>

                                </tr>

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>


                {{-- Smart Buy Requests --}}
                <div class="col-xl-5">

                    <div class="dashboard-card">

                        <div class="dashboard-card__header">

                            <div class="dashboard-card__title">

                                <h3>
                                    Smart Buy Requests
                                </h3>

                                <p>
                                    Requests that need attention.
                                </p>

                            </div>


                            <a
                                href="#"
                                class="dashboard-card__action"
                            >

                                <span>
                                    View All
                                </span>

                                <i class="ri-arrow-right-line"></i>

                            </a>

                        </div>


                        <div class="request-list">


                            <div class="request-item">

                                <div class="request-item__icon">

                                    <i class="ri-shopping-bag-line"></i>

                                </div>


                                <div class="request-item__content">

                                    <h4>
                                        Nike Air Max 270
                                    </h4>

                                    <p>
                                        SB-000125 · Amadou Diallo
                                    </p>

                                </div>


                                <span class="status-badge status-badge--review">
                                    Review
                                </span>

                            </div>


                            <div class="request-item">

                                <div class="request-item__icon">

                                    <i class="ri-smartphone-line"></i>

                                </div>


                                <div class="request-item__content">

                                    <h4>
                                        iPhone 16 Pro
                                    </h4>

                                    <p>
                                        SB-000124 · Mariama Camara
                                    </p>

                                </div>


                                <span class="status-badge status-badge--quote">
                                    Quote
                                </span>

                            </div>


                            <div class="request-item">

                                <div class="request-item__icon">

                                    <i class="ri-t-shirt-line"></i>

                                </div>


                                <div class="request-item__content">

                                    <h4>
                                        Zara Jacket
                                    </h4>

                                    <p>
                                        SB-000123 · Fatoumata Sylla
                                    </p>

                                </div>


                                <span class="status-badge status-badge--paid">
                                    Paid
                                </span>

                            </div>


                            <div class="request-item">

                                <div class="request-item__icon">

                                    <i class="ri-headphone-line"></i>

                                </div>


                                <div class="request-item__content">

                                    <h4>
                                        Sony Headphones
                                    </h4>

                                    <p>
                                        SB-000122 · Ibrahima Bah
                                    </p>

                                </div>


                                <span class="status-badge status-badge--purchased">
                                    Purchased
                                </span>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{--=================================
        Shipment Overview
        =================================--}}
        <div class="dashboard-section">


            <div class="dashboard-section__header">

                <div class="dashboard-section__title">

                    <h2>
                        Shipment Overview
                    </h2>

                    <p>
                        Ecommerce and Smart Buy shipment status.
                    </p>

                </div>


                <a
                    href="#"
                    class="dashboard-section__link"
                >

                    <span>
                        View Shipments
                    </span>

                    <i class="ri-arrow-right-line"></i>

                </a>

            </div>


            <div class="row g-3">


                {{-- Ecommerce Shipments --}}
                <div class="col-lg-6">

                    <div class="shipment-card">


                        <div class="shipment-card__header">

                            <div class="shipment-card__icon">

                                <i class="ri-truck-line"></i>

                            </div>


                            <div class="shipment-card__heading">

                                <h3>
                                    Ecommerce Shipments
                                </h3>

                                <p>
                                    42 active shipments
                                </p>

                            </div>

                        </div>


                        <div class="shipment-stats">

                            <div class="shipment-stat">

                                <strong>
                                    18
                                </strong>

                                <span>
                                    In Transit
                                </span>

                            </div>


                            <div class="shipment-stat">

                                <strong>
                                    12
                                </strong>

                                <span>
                                    Processing
                                </span>

                            </div>


                            <div class="shipment-stat">

                                <strong>
                                    24
                                </strong>

                                <span>
                                    Delivered
                                </span>

                            </div>

                        </div>


                        <div class="shipment-progress">

                            <div class="shipment-progress__header">

                                <span>
                                    Delivery Progress
                                </span>

                                <strong>
                                    68%
                                </strong>

                            </div>


                            <div class="progress-bar">

                                <div
                                    class="progress-bar__value"
                                    style="width: 68%;"
                                ></div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- Smart Buy Shipments --}}
                <div class="col-lg-6">

                    <div class="shipment-card">


                        <div class="shipment-card__header">

                            <div class="shipment-card__icon shipment-card__icon--yellow">

                                <i class="ri-global-line"></i>

                            </div>


                            <div class="shipment-card__heading">

                                <h3>
                                    Smart Buy Shipments
                                </h3>

                                <p>
                                    18 active shipments
                                </p>

                            </div>

                        </div>


                        <div class="shipment-stats">

                            <div class="shipment-stat">

                                <strong>
                                    10
                                </strong>

                                <span>
                                    In Transit
                                </span>

                            </div>


                            <div class="shipment-stat">

                                <strong>
                                    5
                                </strong>

                                <span>
                                    Processing
                                </span>

                            </div>


                            <div class="shipment-stat">

                                <strong>
                                    8
                                </strong>

                                <span>
                                    Delivered
                                </span>

                            </div>

                        </div>


                        <div class="shipment-progress">

                            <div class="shipment-progress__header">

                                <span>
                                    Delivery Progress
                                </span>

                                <strong>
                                    55%
                                </strong>

                            </div>


                            <div class="progress-bar">

                                <div
                                    class="progress-bar__value"
                                    style="width: 55%;"
                                ></div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{--=================================
        Recent Payments & Activity
        =================================--}}
        <div class="dashboard-section">

            <div class="row g-3">


                {{-- Recent Payments --}}
                <div class="col-xl-6">

                    <div class="dashboard-card">

                        <div class="dashboard-card__header">

                            <div class="dashboard-card__title">

                                <h3>
                                    Recent Payments
                                </h3>

                                <p>
                                    Latest successful transactions.
                                </p>

                            </div>


                            <a
                                href="#"
                                class="dashboard-card__action"
                            >

                                <span>
                                    View All
                                </span>

                                <i class="ri-arrow-right-line"></i>

                            </a>

                        </div>


                        <div class="payment-list">


                            <div class="payment-item">

                                <div class="payment-item__icon">

                                    <i class="ri-bank-card-line"></i>

                                </div>


                                <div class="payment-item__content">

                                    <strong>
                                        #PAY-00821
                                    </strong>

                                    <p>
                                        Ecommerce Order #BA-10248
                                    </p>

                                </div>


                                <div class="payment-item__amount">
                                    $245.00
                                </div>

                            </div>


                            <div class="payment-item">

                                <div class="payment-item__icon">

                                    <i class="ri-bank-card-line"></i>

                                </div>


                                <div class="payment-item__content">

                                    <strong>
                                        #PAY-00820
                                    </strong>

                                    <p>
                                        Smart Buy SB-000123
                                    </p>

                                </div>


                                <div class="payment-item__amount">
                                    $418.00
                                </div>

                            </div>


                            <div class="payment-item">

                                <div class="payment-item__icon">

                                    <i class="ri-bank-card-line"></i>

                                </div>


                                <div class="payment-item__content">

                                    <strong>
                                        #PAY-00819
                                    </strong>

                                    <p>
                                        Ecommerce Order #BA-10245
                                    </p>

                                </div>


                                <div class="payment-item__amount">
                                    $89.00
                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- Recent Activity --}}
                <div class="col-xl-6">

                    <div class="dashboard-card">

                        <div class="dashboard-card__header">

                            <div class="dashboard-card__title">

                                <h3>
                                    Recent Activity
                                </h3>

                                <p>
                                    Latest system activities.
                                </p>

                            </div>

                        </div>


                        <div class="activity-list">


                            <div class="activity-item activity-item--success">

                                <h4>
                                    Payment received
                                </h4>

                                <p>
                                    Order #BA-10248 payment confirmed.
                                </p>

                                <time>
                                    10 minutes ago
                                </time>

                            </div>


                            <div class="activity-item">

                                <h4>
                                    Shipment updated
                                </h4>

                                <p>
                                    SH-00482 is now in transit.
                                </p>

                                <time>
                                    35 minutes ago
                                </time>

                            </div>


                            <div class="activity-item activity-item--warning">

                                <h4>
                                    New Smart Buy request
                                </h4>

                                <p>
                                    SB-000125 requires review.
                                </p>

                                <time>
                                    2 hours ago
                                </time>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

@endsection
