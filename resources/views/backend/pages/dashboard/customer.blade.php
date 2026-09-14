@extends('backend.layouts.backend')

@section('title', 'My Dashboard')

@section('content')
    <div class="customer-dashboard-page">
        <div class="customer-dashboard-page__container">

            {{-- Welcome --}}
            <section class="customer-dashboard-page__welcome">
                <div class="customer-dashboard-page__welcome-content">
                    <span class="customer-dashboard-page__eyebrow">
                        My Dashboard
                    </span>

                    <h1 class="customer-dashboard-page__title">
                        Welcome back, {{ $user->name }}
                    </h1>

                    <p class="customer-dashboard-page__description">
                        Manage your orders, track your purchases, and view
                        your account activity from one place.
                    </p>
                </div>

                <div class="customer-dashboard-page__welcome-icon">
                    <i class="ri-dashboard-line"></i>
                </div>
            </section>


            {{-- Statistics --}}
            <section class="customer-dashboard-page__stats">
                <article class="customer-dashboard-page__stat-card">
                    <div class="customer-dashboard-page__stat-icon">
                        <i class="ri-shopping-bag-3-line"></i>
                    </div>

                    <div class="customer-dashboard-page__stat-content">
                        <span class="customer-dashboard-page__stat-label">
                            Total Orders
                        </span>

                        <strong class="customer-dashboard-page__stat-value">
                            {{ number_format($stats['total_orders']) }}
                        </strong>
                    </div>
                </article>


                <article class="customer-dashboard-page__stat-card">
                    <div class="customer-dashboard-page__stat-icon">
                        <i class="ri-checkbox-circle-line"></i>
                    </div>

                    <div class="customer-dashboard-page__stat-content">
                        <span class="customer-dashboard-page__stat-label">
                            Completed
                        </span>

                        <strong class="customer-dashboard-page__stat-value">
                            {{ number_format($stats['completed_orders']) }}
                        </strong>
                    </div>
                </article>


                <article class="customer-dashboard-page__stat-card">
                    <div class="customer-dashboard-page__stat-icon">
                        <i class="ri-time-line"></i>
                    </div>

                    <div class="customer-dashboard-page__stat-content">
                        <span class="customer-dashboard-page__stat-label">
                            Pending
                        </span>

                        <strong class="customer-dashboard-page__stat-value">
                            {{ number_format($stats['pending_orders']) }}
                        </strong>
                    </div>
                </article>


                <article class="customer-dashboard-page__stat-card">
                    <div class="customer-dashboard-page__stat-icon">
                        <i class="ri-wallet-3-line"></i>
                    </div>

                    <div class="customer-dashboard-page__stat-content">
                        <span class="customer-dashboard-page__stat-label">
                            Total Spent
                        </span>

                        <strong class="customer-dashboard-page__stat-value">
                            ${{ number_format($stats['total_spent'], 2) }}
                        </strong>
                    </div>
                </article>
            </section>


            {{-- Main Content --}}
            <div class="customer-dashboard-page__grid">

                {{-- Recent Orders --}}
                <section class="customer-dashboard-page__orders">
                    <div class="customer-dashboard-page__section-header">
                        <div>
                            <span class="customer-dashboard-page__section-eyebrow">
                                Order Activity
                            </span>

                            <h2 class="customer-dashboard-page__section-title">
                                Recent Orders
                            </h2>
                        </div>

                        <a
                            href="{{ route('my-orders') }}"
                            class="customer-dashboard-page__view-link"
                        >
                            View All
                            <i class="ri-arrow-right-line"></i>
                        </a>
                    </div>


                    @if ($recentOrders->isNotEmpty())
                        <div class="customer-dashboard-page__table-wrapper">
                            <table class="customer-dashboard-page__table">
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
                                            <span class="customer-dashboard-page__order-number">
                                                #{{ $order->order_number }}
                                            </span>
                                        </td>

                                        <td>
                                            <span class="customer-dashboard-page__date">
                                                {{ $order->created_at->format('M d, Y') }}
                                            </span>
                                        </td>

                                        <td>
                                            <span
                                                class="customer-dashboard-page__badge customer-dashboard-page__badge--{{ $order->status }}"
                                            >
                                                {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                            </span>
                                        </td>

                                        <td>
                                            <span
                                                class="customer-dashboard-page__badge customer-dashboard-page__badge--payment-{{ $order->payment_status }}"
                                            >
                                                {{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}
                                            </span>
                                        </td>

                                        <td>
                                            <strong class="customer-dashboard-page__order-total">
                                                {{ $order->currency }}
                                                {{ number_format((float) $order->total, 2) }}
                                            </strong>
                                        </td>

                                        <td>
                                            <a
                                                href="{{ route('my-orders.show', $order->order_number) }}"
                                                class="customer-dashboard-page__order-link"
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
                        <div class="customer-dashboard-page__empty">
                            <div class="customer-dashboard-page__empty-icon">
                                <i class="ri-shopping-bag-3-line"></i>
                            </div>

                            <h3 class="customer-dashboard-page__empty-title">
                                No orders yet
                            </h3>

                            <p class="customer-dashboard-page__empty-text">
                                You haven't placed any orders yet.
                            </p>

                            <a
                                href="{{ route('shop') }}"
                                class="customer-dashboard-page__primary-button"
                            >
                                Start Shopping
                                <i class="ri-arrow-right-line"></i>
                            </a>
                        </div>
                    @endif
                </section>


                {{-- Quick Actions --}}
                <aside class="customer-dashboard-page__sidebar">
                    <div class="customer-dashboard-page__section-header">
                        <div>
                            <span class="customer-dashboard-page__section-eyebrow">
                                Quick Access
                            </span>

                            <h2 class="customer-dashboard-page__section-title">
                                Quick Actions
                            </h2>
                        </div>
                    </div>

                    <div class="customer-dashboard-page__actions">
                        <a
                            href="{{ route('my-smart-buy') }}"
                            class="customer-dashboard-page__action"
                        >
                            <span class="customer-dashboard-page__action-icon">
                                <i class="ri-shopping-basket-2-line"></i>
                            </span>

                            <span class="customer-dashboard-page__action-content">
                                <strong>My Smart Buy</strong>
                                <small>Manage your Smart Buy requests</small>
                            </span>

                            <i class="ri-arrow-right-s-line"></i>
                        </a>

                        <a
                            href="{{ route('my-orders') }}"
                            class="customer-dashboard-page__action"
                        >
                            <span class="customer-dashboard-page__action-icon">
                                <i class="ri-shopping-bag-3-line"></i>
                            </span>

                            <span class="customer-dashboard-page__action-content">
                                <strong>My Orders</strong>
                                <small>View your order history</small>
                            </span>

                            <i class="ri-arrow-right-s-line"></i>
                        </a>


                        <a
                            href="{{ route('shop') }}"
                            class="customer-dashboard-page__action"
                        >
                            <span class="customer-dashboard-page__action-icon">
                                <i class="ri-store-2-line"></i>
                            </span>

                            <span class="customer-dashboard-page__action-content">
                                <strong>Continue Shopping</strong>
                                <small>Explore our latest products</small>
                            </span>

                            <i class="ri-arrow-right-s-line"></i>
                        </a>


                        <a
                            href="{{ route('profile') }}"
                            class="customer-dashboard-page__action"
                        >
                            <span class="customer-dashboard-page__action-icon">
                                <i class="ri-user-settings-line"></i>
                            </span>

                            <span class="customer-dashboard-page__action-content">
                                <strong>Account Settings</strong>
                                <small>Manage your profile</small>
                            </span>

                            <i class="ri-arrow-right-s-line"></i>
                        </a>
                    </div>
                </aside>


                {{-- Recent My Requests --}}
                <section class="customer-dashboard-page__requests">
                    <div class="customer-dashboard-page__section-header">
                        <div>
                            <span class="customer-dashboard-page__section-eyebrow">
                                Smart Buy Activity
                            </span>

                            <h2 class="customer-dashboard-page__section-title">
                                Recent My Requests
                            </h2>
                        </div>

                        <a
                            href="{{ route('my-smart-buy') }}"
                            class="customer-dashboard-page__view-link"
                        >
                            View All
                            <i class="ri-arrow-right-line"></i>
                        </a>
                    </div>


                    @if ($recentSmartBuyRequests->isNotEmpty())
                        <div class="customer-dashboard-page__table-wrapper">
                            <table class="customer-dashboard-page__table">
                                <thead>
                                <tr>
                                    <th>Request</th>
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
                                            <span class="customer-dashboard-page__order-number">
                                                #{{ $request->request_number }}
                                            </span>
                                        </td>

                                        <td>
                                            <span class="customer-dashboard-page__date">
                                                {{ $request->created_at->format('M d, Y') }}
                                            </span>
                                        </td>

                                        <td>
                                            <span class="customer-dashboard-page__request-items">
                                                {{ $request->items_count }}
                                                {{ $request->items_count === 1 ? 'Item' : 'Items' }}
                                            </span>
                                        </td>

                                        <td>
                                            <span
                                                class="customer-dashboard-page__badge customer-dashboard-page__badge--{{ $request->status }}"
                                            >
                                                {{ ucfirst(str_replace('_', ' ', $request->status)) }}
                                            </span>
                                        </td>

                                        <td>
                                            <a
                                                href="{{ route('my-smart-buy.details', $request->id) }}"
                                                class="customer-dashboard-page__order-link"
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
                        <div class="customer-dashboard-page__empty">
                            <div class="customer-dashboard-page__empty-icon">
                                <i class="ri-shopping-basket-2-line"></i>
                            </div>

                            <h3 class="customer-dashboard-page__empty-title">
                                No Smart Buy requests yet
                            </h3>

                            <p class="customer-dashboard-page__empty-text">
                                Your recent Smart Buy requests will appear here.
                            </p>

                            <a
                                href="{{ route('my-smart-buy') }}"
                                class="customer-dashboard-page__primary-button"
                            >
                                Create Smart Buy Request
                                <i class="ri-arrow-right-line"></i>
                            </a>
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
                '.customer-dashboard-page'
            );

            if (!dashboard) {
                return;
            }

            const actionLinks = dashboard.querySelectorAll(
                '.customer-dashboard-page__action'
            );

            actionLinks.forEach((link) => {
                link.addEventListener('mouseenter', () => {
                    link.classList.add(
                        'customer-dashboard-page__action--active'
                    );
                });

                link.addEventListener('mouseleave', () => {
                    link.classList.remove(
                        'customer-dashboard-page__action--active'
                    );
                });
            });
        });
    </script>
@endpush
