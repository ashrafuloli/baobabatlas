@extends('backend.layouts.backend')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="admin-dashboard-page">
        <div class="admin-dashboard-page__container">

            {{-- Welcome --}}
            <section class="admin-dashboard-page__welcome">
                <div class="admin-dashboard-page__welcome-content">
                    <span class="admin-dashboard-page__eyebrow">
                        Admin Overview
                    </span>

                    <h1 class="admin-dashboard-page__title">
                        Admin Dashboard
                    </h1>

                    <p class="admin-dashboard-page__description">
                        Monitor your store performance, orders, products,
                        customers and Smart Buy activity from one place.
                    </p>
                </div>

                <div class="admin-dashboard-page__welcome-icon">
                    <i class="ri-dashboard-3-line"></i>
                </div>
            </section>


            {{-- Statistics --}}
            <section class="admin-dashboard-page__stats">

                {{-- Total Orders --}}
                <div class="admin-dashboard-page__stat-card">
                    <div class="admin-dashboard-page__stat-icon">
                        <i class="ri-shopping-bag-3-line"></i>
                    </div>

                    <div class="admin-dashboard-page__stat-content">
                        <span class="admin-dashboard-page__stat-label">
                            Total Orders
                        </span>

                        <strong class="admin-dashboard-page__stat-value">
                            {{ number_format($stats['total_orders']) }}
                        </strong>
                    </div>
                </div>


                {{-- Total Revenue --}}
                <div class="admin-dashboard-page__stat-card">
                    <div class="admin-dashboard-page__stat-icon">
                        <i class="ri-money-dollar-circle-line"></i>
                    </div>

                    <div class="admin-dashboard-page__stat-content">
                        <span class="admin-dashboard-page__stat-label">
                            Total Revenue
                        </span>

                        <strong class="admin-dashboard-page__stat-value">
                            ${{ number_format($stats['total_revenue'], 2) }}
                        </strong>
                    </div>
                </div>


                {{-- Pending Orders --}}
                <div class="admin-dashboard-page__stat-card">
                    <div class="admin-dashboard-page__stat-icon">
                        <i class="ri-time-line"></i>
                    </div>

                    <div class="admin-dashboard-page__stat-content">
                        <span class="admin-dashboard-page__stat-label">
                            Pending Orders
                        </span>

                        <strong class="admin-dashboard-page__stat-value">
                            {{ number_format($stats['pending_orders']) }}
                        </strong>
                    </div>
                </div>


                {{-- Completed Orders --}}
                <div class="admin-dashboard-page__stat-card">
                    <div class="admin-dashboard-page__stat-icon">
                        <i class="ri-checkbox-circle-line"></i>
                    </div>

                    <div class="admin-dashboard-page__stat-content">
                        <span class="admin-dashboard-page__stat-label">
                            Completed Orders
                        </span>

                        <strong class="admin-dashboard-page__stat-value">
                            {{ number_format($stats['completed_orders']) }}
                        </strong>
                    </div>
                </div>


                {{-- Customers --}}
                <div class="admin-dashboard-page__stat-card">
                    <div class="admin-dashboard-page__stat-icon">
                        <i class="ri-group-line"></i>
                    </div>

                    <div class="admin-dashboard-page__stat-content">
                        <span class="admin-dashboard-page__stat-label">
                            Customers
                        </span>

                        <strong class="admin-dashboard-page__stat-value">
                            {{ number_format($stats['total_customers']) }}
                        </strong>
                    </div>
                </div>


                {{-- Products --}}
                <div class="admin-dashboard-page__stat-card">
                    <div class="admin-dashboard-page__stat-icon">
                        <i class="ri-box-3-line"></i>
                    </div>

                    <div class="admin-dashboard-page__stat-content">
                        <span class="admin-dashboard-page__stat-label">
                            Products
                        </span>

                        <strong class="admin-dashboard-page__stat-value">
                            {{ number_format($stats['total_products']) }}
                        </strong>
                    </div>
                </div>


                {{-- Smart Buy Requests --}}
                <div class="admin-dashboard-page__stat-card">
                    <div class="admin-dashboard-page__stat-icon">
                        <i class="ri-shopping-basket-2-line"></i>
                    </div>

                    <div class="admin-dashboard-page__stat-content">
                        <span class="admin-dashboard-page__stat-label">
                            Smart Buy Requests
                        </span>

                        <strong class="admin-dashboard-page__stat-value">
                            {{ number_format($stats['total_smart_buy_requests']) }}
                        </strong>
                    </div>
                </div>


                {{-- Pending Smart Buy --}}
                <div class="admin-dashboard-page__stat-card">
                    <div class="admin-dashboard-page__stat-icon">
                        <i class="ri-loader-4-line"></i>
                    </div>

                    <div class="admin-dashboard-page__stat-content">
                        <span class="admin-dashboard-page__stat-label">
                            Pending Smart Buy
                        </span>

                        <strong class="admin-dashboard-page__stat-value">
                            {{ number_format($stats['pending_smart_buy_requests']) }}
                        </strong>
                    </div>
                </div>

            </section>


            {{-- Main Dashboard Grid --}}
            <div class="admin-dashboard-page__grid">

                {{-- Recent Orders --}}
                <section class="admin-dashboard-page__section">
                    <div class="admin-dashboard-page__section-header">
                        <div>
                            <span class="admin-dashboard-page__section-eyebrow">
                                Store Activity
                            </span>

                            <h2 class="admin-dashboard-page__section-title">
                                Recent Orders
                            </h2>
                        </div>

                        <a
                            href="{{ route('admin-orders') }}"
                            class="admin-dashboard-page__view-link"
                        >
                            View All
                            <i class="ri-arrow-right-line"></i>
                        </a>
                    </div>


                    @if ($recentOrders->isNotEmpty())
                        <div class="admin-dashboard-page__table-wrapper">
                            <table class="admin-dashboard-page__table">
                                <thead>
                                <tr>
                                    <th>Order</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Payment</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach ($recentOrders as $order)
                                    <tr>
                                        <td>
                                            <span
                                                class="admin-dashboard-page__order-number"
                                            >
                                                #{{ $order->order_number }}
                                            </span>
                                        </td>

                                        <td>
                                            <span
                                                class="admin-dashboard-page__date"
                                            >
                                                {{ $order->created_at->format('M d, Y') }}
                                            </span>
                                        </td>

                                        <td>
                                            <span
                                                class="admin-dashboard-page__badge admin-dashboard-page__badge--{{ $order->status }}"
                                            >
                                                {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                            </span>
                                        </td>

                                        <td>
                                            <span
                                                class="admin-dashboard-page__badge admin-dashboard-page__badge--payment-{{ $order->payment_status }}"
                                            >
                                                {{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}
                                            </span>
                                        </td>

                                        <td>
                                            <strong
                                                class="admin-dashboard-page__order-total"
                                            >
                                                ${{ number_format((float) $order->total, 2) }}
                                            </strong>
                                        </td>

                                        <td>
                                            <a
                                                href="{{ route('admin-order-details', ['order' => $order->id]) }}"
                                                class="admin-dashboard-page__order-link"
                                                aria-label="View order {{ $order->order_number }}"
                                            >
                                                <i class="ri-arrow-right-line"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="admin-dashboard-page__empty">
                            <div class="admin-dashboard-page__empty-icon">
                                <i class="ri-shopping-bag-3-line"></i>
                            </div>

                            <h3 class="admin-dashboard-page__empty-title">
                                No orders yet
                            </h3>

                            <p class="admin-dashboard-page__empty-text">
                                New customer orders will appear here.
                            </p>
                        </div>
                    @endif
                </section>


                {{-- Quick Actions --}}
                <aside class="admin-dashboard-page__sidebar">
                    <div class="admin-dashboard-page__section-header">
                        <div>
                            <span class="admin-dashboard-page__section-eyebrow">
                                Management
                            </span>

                            <h2 class="admin-dashboard-page__section-title">
                                Quick Actions
                            </h2>
                        </div>
                    </div>


                    <div class="admin-dashboard-page__actions">

                        {{-- Orders --}}
                        <a
                            href="{{ route('admin-orders') }}"
                            class="admin-dashboard-page__action"
                        >
                            <span class="admin-dashboard-page__action-icon">
                                <i class="ri-shopping-bag-3-line"></i>
                            </span>

                            <span class="admin-dashboard-page__action-content">
                                <strong>Manage Orders</strong>
                                <small>View and process orders</small>
                            </span>

                            <i class="ri-arrow-right-line"></i>
                        </a>


                        {{-- Ecommerce Reports --}}
                        <a
                            href="{{ route('reports.ecommerce') }}"
                            class="admin-dashboard-page__action"
                        >
                            <span class="admin-dashboard-page__action-icon">
                                <i class="ri-bar-chart-box-line"></i>
                            </span>

                            <span class="admin-dashboard-page__action-content">
                                <strong>E-commerce Reports</strong>
                                <small>Review store performance</small>
                            </span>

                            <i class="ri-arrow-right-line"></i>
                        </a>


                        {{-- Smart Buy --}}
                        <a
                            href="{{ route('smart-buy') }}"
                            class="admin-dashboard-page__action"
                        >
                            <span class="admin-dashboard-page__action-icon">
                                <i class="ri-shopping-basket-2-line"></i>
                            </span>

                            <span class="admin-dashboard-page__action-content">
                                <strong>Smart Buy Requests</strong>
                                <small>Manage customer requests</small>
                            </span>

                            <i class="ri-arrow-right-line"></i>
                        </a>


                        {{-- Smart Buy Reports --}}
                        <a
                            href="{{ route('reports.smart-buy') }}"
                            class="admin-dashboard-page__action"
                        >
                            <span class="admin-dashboard-page__action-icon">
                                <i class="ri-pie-chart-line"></i>
                            </span>

                            <span class="admin-dashboard-page__action-content">
                                <strong>Smart Buy Reports</strong>
                                <small>Review Smart Buy activity</small>
                            </span>

                            <i class="ri-arrow-right-line"></i>
                        </a>


                        {{-- Products --}}
                        <a
                            href="{{ route('admin-products') }}"
                            class="admin-dashboard-page__action"
                        >
                            <span class="admin-dashboard-page__action-icon">
                                <i class="ri-box-3-line"></i>
                            </span>

                            <span class="admin-dashboard-page__action-content">
                                <strong>Manage Products</strong>
                                <small>Manage product catalog</small>
                            </span>

                            <i class="ri-arrow-right-line"></i>
                        </a>


                        {{-- Inventory --}}
                        <a
                            href="{{ route('admin-inventory') }}"
                            class="admin-dashboard-page__action"
                        >
                            <span class="admin-dashboard-page__action-icon">
                                <i class="ri-stack-line"></i>
                            </span>

                            <span class="admin-dashboard-page__action-content">
                                <strong>Inventory</strong>
                                <small>Manage stock levels</small>
                            </span>

                            <i class="ri-arrow-right-line"></i>
                        </a>

                    </div>
                </aside>


                {{-- Recent Smart Buy Requests --}}
                <section
                    class="admin-dashboard-page__section admin-dashboard-page__requests"
                >
                    <div class="admin-dashboard-page__section-header">
                        <div>
                            <span class="admin-dashboard-page__section-eyebrow">
                                Smart Buy Activity
                            </span>

                            <h2 class="admin-dashboard-page__section-title">
                                Recent Smart Buy Requests
                            </h2>
                        </div>

                        <a
                            href="{{ route('smart-buy') }}"
                            class="admin-dashboard-page__view-link"
                        >
                            View All
                            <i class="ri-arrow-right-line"></i>
                        </a>
                    </div>


                    @if ($recentSmartBuyRequests->isNotEmpty())
                        <div class="admin-dashboard-page__table-wrapper">
                            <table class="admin-dashboard-page__table">
                                <thead>
                                <tr>
                                    <th>Request</th>
                                    <th>Customer ID</th>
                                    <th>Date</th>
                                    <th>Items</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach ($recentSmartBuyRequests as $request)
                                    <tr>
                                        <td>
                                            <span
                                                class="admin-dashboard-page__order-number"
                                            >
                                                #{{ $request->request_number }}
                                            </span>
                                        </td>

                                        <td>
                                            <span
                                                class="admin-dashboard-page__customer-name"
                                            >
                                                #{{ $request->user_id }}
                                            </span>
                                        </td>

                                        <td>
                                            <span
                                                class="admin-dashboard-page__date"
                                            >
                                                {{ $request->created_at->format('M d, Y') }}
                                            </span>
                                        </td>

                                        <td>
                                            <span
                                                class="admin-dashboard-page__request-items"
                                            >
                                                {{ $request->items_count }}
                                                {{ $request->items_count === 1 ? 'Item' : 'Items' }}
                                            </span>
                                        </td>

                                        <td>
                                            <span
                                                class="admin-dashboard-page__badge admin-dashboard-page__badge--{{ $request->status }}"
                                            >
                                                {{ ucfirst(str_replace('_', ' ', $request->status)) }}
                                            </span>
                                        </td>

                                        <td>
                                            <a
                                                href="{{ route('smart-buy.details', ['smartBuy' => $request->id]) }}"
                                                class="admin-dashboard-page__order-link"
                                                aria-label="View request {{ $request->request_number }}"
                                            >
                                                <i class="ri-arrow-right-line"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="admin-dashboard-page__empty">
                            <div class="admin-dashboard-page__empty-icon">
                                <i class="ri-shopping-basket-2-line"></i>
                            </div>

                            <h3 class="admin-dashboard-page__empty-title">
                                No Smart Buy requests yet
                            </h3>

                            <p class="admin-dashboard-page__empty-text">
                                New Smart Buy requests will appear here.
                            </p>
                        </div>
                    @endif
                </section>

            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const dashboard = document.querySelector(
                '.admin-dashboard-page'
            );

            if (!dashboard) {
                return;
            }

            const actions = dashboard.querySelectorAll(
                '.admin-dashboard-page__action'
            );

            actions.forEach((action) => {
                action.addEventListener('mouseenter', () => {
                    action.classList.add(
                        'admin-dashboard-page__action--active'
                    );
                });

                action.addEventListener('mouseleave', () => {
                    action.classList.remove(
                        'admin-dashboard-page__action--active'
                    );
                });
            });
        });
    </script>
@endpush
