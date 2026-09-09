@extends('backend.layouts.backend')

@section('title', 'Orders')

@section('content')

    <div class="orders-page">

        {{-- ================================================================ --}}
        {{-- PAGE HEADER --}}
        {{-- ================================================================ --}}

        <div class="orders-page__header">

            <div>

                <span class="orders-page__eyebrow">
                    Ecommerce
                </span>

                <h1>
                    Orders
                </h1>

                <p>
                    Manage customer ecommerce orders and their status.
                </p>

            </div>

            <div class="orders-page__header-actions">

                <button
                    type="button"
                    class="orders-export-btn"
                    data-export-orders
                >
                    <i class="ri-download-2-line"></i>

                    Export
                </button>

            </div>

        </div>


        {{-- ================================================================ --}}
        {{-- ORDER STATS --}}
        {{-- ================================================================ --}}

        <div class="orders-stats">

            {{-- Total Orders --}}
            <div class="orders-stat-card">

                <div class="orders-stat-card__icon">
                    <i class="ri-shopping-bag-3-line"></i>
                </div>

                <div>

                    <span>
                        Total Orders
                    </span>

                    <strong>
                        {{ number_format($totalOrders) }}
                    </strong>

                </div>

            </div>


            {{-- Pending --}}
            <div class="orders-stat-card">

                <div class="orders-stat-card__icon orders-stat-card__icon--warning">
                    <i class="ri-time-line"></i>
                </div>

                <div>

                    <span>
                        Pending
                    </span>

                    <strong>
                        {{ number_format($pendingOrders) }}
                    </strong>

                </div>

            </div>


            {{-- Processing --}}
            <div class="orders-stat-card">

                <div class="orders-stat-card__icon orders-stat-card__icon--info">
                    <i class="ri-loader-4-line"></i>
                </div>

                <div>

                    <span>
                        Processing
                    </span>

                    <strong>
                        {{ number_format($processingOrders) }}
                    </strong>

                </div>

            </div>


            {{-- Completed --}}
            <div class="orders-stat-card">

                <div class="orders-stat-card__icon orders-stat-card__icon--success">
                    <i class="ri-checkbox-circle-line"></i>
                </div>

                <div>

                    <span>
                        Completed
                    </span>

                    <strong>
                        {{ number_format($completedOrders) }}
                    </strong>

                </div>

            </div>

        </div>


        {{-- ================================================================ --}}
        {{-- ORDERS CARD --}}
        {{-- ================================================================ --}}

        <div class="orders-card">

            {{-- ============================================================ --}}
            {{-- TOOLBAR --}}
            {{-- ============================================================ --}}

            <form
                action="{{ route('admin-orders') }}"
                method="GET"
                class="orders-toolbar"
                data-orders-filter-form
            >

                {{-- Search --}}
                <div class="orders-search">

                    <i class="ri-search-line"></i>

                    <input
                        type="search"
                        name="search"
                        value="{{ $search }}"
                        placeholder="Search order ID, customer or email..."
                    >

                </div>


                <div class="orders-toolbar__filters">

                    {{-- Status --}}
                    <select
                        name="status"
                        class="orders-filter"
                        data-orders-filter
                    >

                        <option value="">
                            All Status
                        </option>

                        @foreach ($orderStatuses as $orderStatus)

                            <option
                                value="{{ $orderStatus }}"
                                @selected($status === $orderStatus)
                            >
                                {{ ucfirst($orderStatus) }}
                            </option>

                        @endforeach

                    </select>


                    {{-- Payment --}}
                    <select
                        name="payment_status"
                        class="orders-filter"
                        data-orders-filter
                    >

                        <option value="">
                            Payment Status
                        </option>

                        @foreach ($paymentStatuses as $paymentStatusOption)

                            <option
                                value="{{ $paymentStatusOption }}"
                                @selected($paymentStatus === $paymentStatusOption)
                            >
                                {{ ucfirst($paymentStatusOption) }}
                            </option>

                        @endforeach

                    </select>


                    {{-- Date --}}
                    <select
                        name="date"
                        class="orders-filter"
                        data-orders-filter
                    >

                        <option value="">
                            All Dates
                        </option>

                        <option
                            value="today"
                            @selected($date === 'today')
                        >
                            Today
                        </option>

                        <option
                            value="week"
                            @selected($date === 'week')
                        >
                            This Week
                        </option>

                        <option
                            value="month"
                            @selected($date === 'month')
                        >
                            This Month
                        </option>

                        <option
                            value="year"
                            @selected($date === 'year')
                        >
                            This Year
                        </option>

                    </select>

                </div>

            </form>


            {{-- ============================================================ --}}
            {{-- TABLE --}}
            {{-- ============================================================ --}}

            <div class="orders-table-wrapper">

                <table class="orders-table">

                    <thead>

                    <tr>

                        <th>
                            Order
                        </th>

                        <th>
                            Customer
                        </th>

                        <th>
                            Products
                        </th>

                        <th>
                            Total
                        </th>

                        <th>
                            Payment
                        </th>

                        <th>
                            Status
                        </th>

                        <th>
                            Date
                        </th>

                        <th>
                            Action
                        </th>

                    </tr>

                    </thead>


                    <tbody>

                    @forelse ($orders as $order)

                        @php
                            $customerName = trim(
                                $order->first_name . ' ' . $order->last_name
                            );

                            $customerInitials = collect(
                                preg_split('/\s+/', $customerName)
                            )
                                ->filter()
                                ->take(2)
                                ->map(
                                    fn ($name) => strtoupper(
                                        mb_substr($name, 0, 1)
                                    )
                                )
                                ->implode('');

                            $statusClass = match ($order->status) {
                                \App\Models\Order::STATUS_PENDING => 'pending',
                                \App\Models\Order::STATUS_PAID => 'paid',
                                \App\Models\Order::STATUS_PROCESSING => 'processing',
                                \App\Models\Order::STATUS_COMPLETED => 'completed',
                                \App\Models\Order::STATUS_CANCELLED => 'cancelled',
                                \App\Models\Order::STATUS_FAILED => 'failed',
                                default => 'pending',
                            };

                            $paymentClass = match ($order->payment_status) {
                                \App\Models\Order::PAYMENT_STATUS_PAID => 'paid',
                                \App\Models\Order::PAYMENT_STATUS_PENDING => 'pending',
                                \App\Models\Order::PAYMENT_STATUS_FAILED => 'failed',
                                \App\Models\Order::PAYMENT_STATUS_REFUNDED => 'refunded',
                                default => 'pending',
                            };
                        @endphp

                        <tr>

                            {{-- Order --}}
                            <td>

                                <a
                                    href="{{ route('admin-order-details', ['order' => $order]) }}"
                                    class="orders-number"
                                >
                                    #{{ $order->order_number }}
                                </a>

                            </td>


                            {{-- Customer --}}
                            <td>

                                <div class="orders-customer">

                                    <div class="orders-customer__avatar">
                                        {{ $customerInitials ?: '?' }}
                                    </div>

                                    <div>

                                        <strong>
                                            {{ $customerName ?: 'Guest Customer' }}
                                        </strong>

                                        <span>
                                            {{ $order->email }}
                                        </span>

                                    </div>

                                </div>

                            </td>


                            {{-- Products --}}
                            <td>

                                <span class="orders-products">
                                    {{ $order->items_count }}
                                    {{ $order->items_count === 1 ? 'Item' : 'Items' }}
                                </span>

                            </td>


                            {{-- Total --}}
                            <td>

                                <strong class="orders-total">
                                    ${{ number_format((float) $order->total, 2) }}
                                </strong>

                            </td>


                            {{-- Payment --}}
                            <td>

                                <span
                                    class="orders-payment orders-payment--{{ $paymentClass }}"
                                >

                                    <i></i>

                                    {{ ucfirst($order->payment_status) }}

                                </span>

                            </td>


                            {{-- Status --}}
                            <td>

                                <span
                                    class="orders-status orders-status--{{ $statusClass }}"
                                >

                                    <i></i>

                                    {{ ucfirst($order->status) }}

                                </span>

                            </td>


                            {{-- Date --}}
                            <td>

                                <span class="orders-date">
                                    {{ $order->created_at?->format('M d, Y') }}
                                </span>

                            </td>


                            {{-- Action --}}
                            <td>

                                <a
                                    href="{{ route('admin-order-details', ['order' => $order]) }}"
                                    class="orders-view-btn"
                                >

                                    <i class="ri-eye-line"></i>

                                    View

                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="8"
                                class="orders-empty"
                            >

                                <div class="orders-empty__content">

                                    <div class="orders-empty__icon">
                                        <i class="ri-shopping-bag-3-line"></i>
                                    </div>

                                    <h3>
                                        No orders found
                                    </h3>

                                    <p>
                                        Try adjusting your search or filters.
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>


            {{-- ============================================================ --}}
            {{-- PAGINATION --}}
            {{-- ============================================================ --}}

            @if ($orders->total() > 0)

                <div class="orders-pagination">

                    <div class="orders-pagination__info">

                        Showing
                        <strong>
                            {{ $orders->firstItem() }}
                        </strong>

                        to

                        <strong>
                            {{ $orders->lastItem() }}
                        </strong>

                        of

                        <strong>
                            {{ $orders->total() }}
                        </strong>

                        orders

                    </div>


                    <div class="orders-pagination__buttons">

                        @if ($orders->onFirstPage())

                            <button
                                type="button"
                                disabled
                            >
                                <i class="ri-arrow-left-s-line"></i>
                            </button>

                        @else

                            <a href="{{ $orders->previousPageUrl() }}">
                                <i class="ri-arrow-left-s-line"></i>
                            </a>

                        @endif


                        @foreach ($orders->getUrlRange(
                            max(1, $orders->currentPage() - 2),
                            min($orders->lastPage(), $orders->currentPage() + 2)
                        ) as $page => $url)

                            @if ($page === $orders->currentPage())

                                <button
                                    type="button"
                                    class="active"
                                >
                                    {{ $page }}
                                </button>

                            @else

                                <a href="{{ $url }}">
                                    {{ $page }}
                                </a>

                            @endif

                        @endforeach


                        @if ($orders->hasMorePages())

                            <a href="{{ $orders->nextPageUrl() }}">
                                <i class="ri-arrow-right-s-line"></i>
                            </a>

                        @else

                            <button
                                type="button"
                                disabled
                            >
                                <i class="ri-arrow-right-s-line"></i>
                            </button>

                        @endif

                    </div>

                </div>

            @endif

        </div>

    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const ordersPage = document.querySelector(".orders-page");

            if (!ordersPage) {
                return;
            }

            const filterForm = ordersPage.querySelector(
                "[data-orders-filter-form]",
            );

            const filterFields = ordersPage.querySelectorAll(
                "[data-orders-filter]",
            );

            const searchInput = filterForm?.querySelector(
                'input[name="search"]',
            );

            const exportButton = ordersPage.querySelector(
                "[data-export-orders]",
            );

            filterFields.forEach(function (field) {
                field.addEventListener("change", function () {
                    if (!filterForm) {
                        return;
                    }

                    filterForm.submit();
                });
            });

            if (filterForm) {
                filterForm.addEventListener("submit", function () {
                    if (searchInput && searchInput.value.trim() === "") {
                        searchInput.disabled = true;
                    }
                });
            }

            if (exportButton) {
                exportButton.addEventListener("click", function () {
                    if (!filterForm) {
                        return;
                    }

                    const params = new URLSearchParams(
                        new FormData(filterForm),
                    );

                    params.delete("_token");

                    const exportUrl =
                        `${filterForm.action}/export?${params.toString()}`;

                    window.location.href = exportUrl;
                });
            }
        });
    </script>
@endpush
