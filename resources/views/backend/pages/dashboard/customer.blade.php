@extends('backend.layouts.backend')

@section('title', 'Dashboard')

@section('content')

    <div class="customer-dashboard">

        {{--=================================
        Dashboard Header
        =================================--}}
        <div class="customer-dashboard__header">

            <div class="customer-dashboard__header-content">

                <span class="customer-dashboard__eyebrow">
                    My Dashboard
                </span>

                <h1>
                    Welcome back, Demo Client!
                </h1>

                <p>
                    Manage your orders, Smart Buy requests, payments, and shipments.
                </p>

            </div>


            <div class="customer-dashboard__date">

                <i class="ri-calendar-line"></i>

                <span>
                    August 15, 2026
                </span>

            </div>

        </div>


        {{--=================================
        Statistics
        =================================--}}
        <div class="customer-dashboard__stats">


            {{-- Orders --}}
            <div class="customer-stat-card">

                <div class="customer-stat-card__icon ecommerce">

                    <i class="ri-shopping-bag-3-line"></i>

                </div>


                <div class="customer-stat-card__content">

                    <span>
                        My Orders
                    </span>

                    <h3>
                        12
                    </h3>

                    <small>
                        2 active orders
                    </small>

                </div>

            </div>


            {{-- Smart Buy --}}
            <div class="customer-stat-card">

                <div class="customer-stat-card__icon smart-buy">

                    <i class="ri-global-line"></i>

                </div>


                <div class="customer-stat-card__content">

                    <span>
                        Smart Buy Requests
                    </span>

                    <h3>
                        4
                    </h3>

                    <small>
                        1 needs your action
                    </small>

                </div>

            </div>


            {{-- Pending Payments --}}
            <div class="customer-stat-card">

                <div class="customer-stat-card__icon payment">

                    <i class="ri-bank-card-line"></i>

                </div>


                <div class="customer-stat-card__content">

                    <span>
                        Pending Payments
                    </span>

                    <h3>
                        2
                    </h3>

                    <small>
                        Requires attention
                    </small>

                </div>

            </div>


            {{-- Active Shipments --}}
            <div class="customer-stat-card">

                <div class="customer-stat-card__icon shipment">

                    <i class="ri-truck-line"></i>

                </div>


                <div class="customer-stat-card__content">

                    <span>
                        Active Shipments
                    </span>

                    <h3>
                        3
                    </h3>

                    <small>
                        Currently in transit
                    </small>

                </div>

            </div>

        </div>


        {{--=================================
        Quick Actions
        =================================--}}
        <div class="customer-dashboard__quick-actions">


            {{-- Shop Now --}}
            <a href="#" class="customer-action-card">

                <div class="customer-action-card__icon ecommerce">

                    <i class="ri-store-2-line"></i>

                </div>


                <div class="customer-action-card__content">

                    <strong>
                        Shop Now
                    </strong>

                    <span>
                        Explore our products
                    </span>

                </div>


                <div class="customer-action-card__arrow">

                    <i class="ri-arrow-right-line"></i>

                </div>

            </a>


            {{-- Start Smart Buy --}}
            <a href="#" class="customer-action-card">

                <div class="customer-action-card__icon smart-buy">

                    <i class="ri-global-line"></i>

                </div>


                <div class="customer-action-card__content">

                    <strong>
                        Start Smart Buy
                    </strong>

                    <span>
                        Find it anywhere, we buy it
                    </span>

                </div>


                <div class="customer-action-card__arrow">

                    <i class="ri-arrow-right-line"></i>

                </div>

            </a>


            {{-- Track Shipment --}}
            <a href="#" class="customer-action-card">

                <div class="customer-action-card__icon shipment">

                    <i class="ri-map-pin-line"></i>

                </div>


                <div class="customer-action-card__content">

                    <strong>
                        Track Shipment
                    </strong>

                    <span>
                        Check your delivery status
                    </span>

                </div>


                <div class="customer-action-card__arrow">

                    <i class="ri-arrow-right-line"></i>

                </div>

            </a>

        </div>


        {{--=================================
        Main Dashboard Grid
        =================================--}}
        <div class="customer-dashboard__grid">


            {{-- Recent Orders --}}
            <div class="customer-dashboard-card">

                <div class="customer-dashboard-card__header">

                    <div>

                        <h4>
                            Recent Orders
                        </h4>

                        <p>
                            Your latest ecommerce orders.
                        </p>

                    </div>


                    <a href="#">

                        <span>
                            View All
                        </span>

                        <i class="ri-arrow-right-line"></i>

                    </a>

                </div>


                <div class="customer-table-wrapper">

                    <table class="customer-table">

                        <thead>

                        <tr>

                            <th>
                                Order
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

                                <strong>
                                    #BA-10248
                                </strong>

                            </td>


                            <td>
                                Aug 15, 2026
                            </td>


                            <td>

                                <strong>
                                    $245.00
                                </strong>

                            </td>


                            <td>

                                <span class="customer-status success">

                                    <i class="ri-checkbox-circle-fill"></i>

                                    Completed

                                </span>

                            </td>

                        </tr>


                        <tr>

                            <td>

                                <strong>
                                    #BA-10247
                                </strong>

                            </td>


                            <td>
                                Aug 14, 2026
                            </td>


                            <td>

                                <strong>
                                    $128.50
                                </strong>

                            </td>


                            <td>

                                <span class="customer-status warning">

                                    <i class="ri-time-line"></i>

                                    Processing

                                </span>

                            </td>

                        </tr>


                        <tr>

                            <td>

                                <strong>
                                    #BA-10246
                                </strong>

                            </td>


                            <td>
                                Aug 12, 2026
                            </td>


                            <td>

                                <strong>
                                    $560.00
                                </strong>

                            </td>


                            <td>

                                <span class="customer-status info">

                                    <i class="ri-truck-line"></i>

                                    Shipped

                                </span>

                            </td>

                        </tr>


                        </tbody>

                    </table>

                </div>

            </div>


            {{-- My Smart Buy --}}
            <div class="customer-dashboard-card">

                <div class="customer-dashboard-card__header">

                    <div>

                        <h4>
                            My Smart Buy
                        </h4>

                        <p>
                            Your latest product requests.
                        </p>

                    </div>


                    <a href="#">

                        <span>
                            View All
                        </span>

                        <i class="ri-arrow-right-line"></i>

                    </a>

                </div>


                <div class="customer-request-list">


                    {{-- Request Item --}}
                    <div class="customer-request-item">

                        <div class="customer-request-item__icon">

                            <i class="ri-shopping-bag-line"></i>

                        </div>


                        <div class="customer-request-item__content">

                            <strong>
                                Nike Air Max 270
                            </strong>

                            <span>
                                SB-000125 · Aug 15
                            </span>

                        </div>


                        <span class="customer-status warning">
                            Quote Ready
                        </span>

                    </div>


                    {{-- Request Item --}}
                    <div class="customer-request-item">

                        <div class="customer-request-item__icon">

                            <i class="ri-smartphone-line"></i>

                        </div>


                        <div class="customer-request-item__content">

                            <strong>
                                iPhone 16 Pro
                            </strong>

                            <span>
                                SB-000124 · Aug 13
                            </span>

                        </div>


                        <span class="customer-status info">
                            Processing
                        </span>

                    </div>


                    {{-- Request Item --}}
                    <div class="customer-request-item">

                        <div class="customer-request-item__icon">

                            <i class="ri-t-shirt-line"></i>

                        </div>


                        <div class="customer-request-item__content">

                            <strong>
                                Zara Jacket
                            </strong>

                            <span>
                                SB-000123 · Aug 10
                            </span>

                        </div>


                        <span class="customer-status success">
                            Purchased
                        </span>

                    </div>

                </div>

            </div>

        </div>


        {{--=================================
        Active Shipments
        =================================--}}
        <div class="customer-dashboard__section">

            <div class="customer-dashboard__section-header">

                <div>

                    <h4>
                        Active Shipments
                    </h4>

                    <p>
                        Track your current deliveries.
                    </p>

                </div>


                <a href="#">

                    <span>
                        View All
                    </span>

                    <i class="ri-arrow-right-line"></i>

                </a>

            </div>


            <div class="customer-shipment-grid">


                {{-- Ecommerce Shipment --}}
                <div class="customer-shipment-card">

                    <div class="customer-shipment-card__header">

                        <div class="customer-shipment-card__icon ecommerce">

                            <i class="ri-shopping-bag-3-line"></i>

                        </div>


                        <div class="customer-shipment-card__title">

                            <h5>
                                Ecommerce Order
                            </h5>

                            <span>
                                #BA-10246
                            </span>

                        </div>


                        <span class="customer-status info">
                            In Transit
                        </span>

                    </div>


                    <div class="customer-shipment-card__route">

                        <div class="customer-shipment-card__location">

                            <span>
                                From
                            </span>

                            <strong>
                                United States
                            </strong>

                        </div>


                        <div class="customer-shipment-card__route-line">

                            <i class="ri-truck-line"></i>

                        </div>


                        <div class="customer-shipment-card__location destination">

                            <span>
                                To
                            </span>

                            <strong>
                                Guinea
                            </strong>

                        </div>

                    </div>


                    <div class="customer-progress">

                        <div class="customer-progress__top">

                            <span>
                                Shipment Progress
                            </span>

                            <strong>
                                65%
                            </strong>

                        </div>


                        <div class="customer-progress__bar">

                            <span style="width: 65%;"></span>

                        </div>

                    </div>


                    <div class="customer-shipment-card__footer">

                        <span>

                            Tracking:

                            <strong>
                                BAE-845291
                            </strong>

                        </span>


                        <a href="#">

                            Track

                            <i class="ri-arrow-right-line"></i>

                        </a>

                    </div>

                </div>


                {{-- Smart Buy Shipment --}}
                <div class="customer-shipment-card">

                    <div class="customer-shipment-card__header">

                        <div class="customer-shipment-card__icon smart-buy">

                            <i class="ri-global-line"></i>

                        </div>


                        <div class="customer-shipment-card__title">

                            <h5>
                                Smart Buy
                            </h5>

                            <span>
                                SB-000123
                            </span>

                        </div>


                        <span class="customer-status info">
                            In Transit
                        </span>

                    </div>


                    <div class="customer-shipment-card__route">

                        <div class="customer-shipment-card__location">

                            <span>
                                From
                            </span>

                            <strong>
                                Turkey
                            </strong>

                        </div>


                        <div class="customer-shipment-card__route-line">

                            <i class="ri-truck-line"></i>

                        </div>


                        <div class="customer-shipment-card__location destination">

                            <span>
                                To
                            </span>

                            <strong>
                                Guinea
                            </strong>

                        </div>

                    </div>


                    <div class="customer-progress">

                        <div class="customer-progress__top">

                            <span>
                                Shipment Progress
                            </span>

                            <strong>
                                42%
                            </strong>

                        </div>


                        <div class="customer-progress__bar">

                            <span style="width: 42%;"></span>

                        </div>

                    </div>


                    <div class="customer-shipment-card__footer">

                        <span>

                            Tracking:

                            <strong>
                                SBX-582014
                            </strong>

                        </span>


                        <a href="#">

                            Track

                            <i class="ri-arrow-right-line"></i>

                        </a>

                    </div>

                </div>

            </div>

        </div>


        {{--=================================
        Bottom Dashboard Grid
        =================================--}}
        <div class="customer-dashboard__bottom-grid">


            {{-- Pending Payments --}}
            <div class="customer-dashboard-card">

                <div class="customer-dashboard-card__header">

                    <div>

                        <h4>
                            Pending Payments
                        </h4>

                        <p>
                            Payments that require your attention.
                        </p>

                    </div>


                    <a href="#">

                        <span>
                            View All
                        </span>

                        <i class="ri-arrow-right-line"></i>

                    </a>

                </div>


                <div class="customer-payment-list">


                    {{-- Payment Item --}}
                    <div class="customer-payment-item">

                        <div class="customer-payment-item__icon">

                            <i class="ri-bank-card-line"></i>

                        </div>


                        <div class="customer-payment-item__content">

                            <strong>
                                Smart Buy Quote
                            </strong>

                            <span>
                                SB-000125
                            </span>

                        </div>


                        <div class="customer-payment-item__amount">

                            <strong>
                                $385.00
                            </strong>

                            <a href="#">
                                Pay Now
                            </a>

                        </div>

                    </div>


                    {{-- Payment Item --}}
                    <div class="customer-payment-item">

                        <div class="customer-payment-item__icon">

                            <i class="ri-bank-card-line"></i>

                        </div>


                        <div class="customer-payment-item__content">

                            <strong>
                                Ecommerce Order
                            </strong>

                            <span>
                                #BA-10247
                            </span>

                        </div>


                        <div class="customer-payment-item__amount">

                            <strong>
                                $128.50
                            </strong>

                            <a href="#">
                                Pay Now
                            </a>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Account --}}
            <div class="customer-dashboard-card">

                <div class="customer-dashboard-card__header">

                    <div>

                        <h4>
                            Account
                        </h4>

                        <p>
                            Manage your account information.
                        </p>

                    </div>


                    <a href="#">

                        <span>
                            Profile
                        </span>

                        <i class="ri-arrow-right-line"></i>

                    </a>

                </div>


                <div class="customer-account-summary">

                    <div class="customer-account-summary__avatar">
                        DC
                    </div>


                    <div class="customer-account-summary__content">

                        <strong>
                            Demo Client
                        </strong>

                        <span>
                            client@gmail.com
                        </span>

                        <span>
                            Guinea
                        </span>

                    </div>

                </div>


                <div class="customer-account-links">

                    <a href="#">

                        <span>

                            <i class="ri-user-line"></i>

                            My Profile

                        </span>

                        <i class="ri-arrow-right-s-line"></i>

                    </a>


                    <a href="#">

                        <span>

                            <i class="ri-notification-3-line"></i>

                            Notifications

                        </span>

                        <i class="ri-arrow-right-s-line"></i>

                    </a>


                    <a href="#">

                        <span>

                            <i class="ri-settings-3-line"></i>

                            Account Settings

                        </span>

                        <i class="ri-arrow-right-s-line"></i>

                    </a>

                </div>

            </div>

        </div>

    </div>

@endsection
