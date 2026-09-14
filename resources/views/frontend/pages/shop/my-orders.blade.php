@extends('frontend.layouts.frontend')

@section('title', 'My Orders')

@section('contents')

    <div class="my-orders-page">

        <div class="container">

            {{-- Breadcrumb --}}
            <div class="my-orders-page__breadcrumb">

                <a href="{{ url('/') }}">
                    Shop
                </a>

                <i class="ri-arrow-right-s-line"></i>

                <span>
                    My Orders
                </span>

            </div>


            {{-- Page Header --}}
            <div class="my-orders-page__header">

                <div class="my-orders-page__header-content">

                    <span class="my-orders-page__eyebrow">
                        ORDER HISTORY
                    </span>

                    <h1 class="my-orders-page__title">
                        My Orders
                    </h1>

                    <p class="my-orders-page__subtitle">
                        Track and manage your recent orders.
                    </p>

                </div>


                <a
                    href="{{ route('shop') }}"
                    class="my-orders-page__shop-btn"
                >
                    <i class="ri-arrow-left-line"></i>

                    Continue Shopping
                </a>

            </div>


            {{-- Order Controls --}}
            <div class="my-orders-page__controls">

                <div class="my-orders-page__search">

                    <i class="ri-search-line"></i>

                    <input
                        type="search"
                        class="my-orders-page__search-input"
                        placeholder="Search orders..."
                        aria-label="Search orders"
                        autocomplete="off"
                    >

                </div>


                <div class="my-orders-page__filter">

                    <div class="my-orders-page__status-filter">

                        <div class="status-select">

                            <button
                                type="button"
                                class="status-select-trigger"
                                aria-expanded="false"
                                aria-haspopup="listbox"
                            >
                                <span class="status-select-value">

                                    <span class="status-label">
                                        Status:
                                    </span>

                                    <strong>
                                        All Orders
                                    </strong>

                                </span>

                                <i class="ri-arrow-down-s-line"></i>

                            </button>


                            <div
                                class="status-select-options"
                                role="listbox"
                            >

                                <button
                                    type="button"
                                    class="status-option is-selected"
                                    data-value="all"
                                    role="option"
                                    aria-selected="true"
                                >
                                    All Orders
                                </button>


                                <button
                                    type="button"
                                    class="status-option"
                                    data-value="pending"
                                    role="option"
                                    aria-selected="false"
                                >
                                    Pending
                                </button>


                                <button
                                    type="button"
                                    class="status-option"
                                    data-value="paid"
                                    role="option"
                                    aria-selected="false"
                                >
                                    Paid
                                </button>


                                <button
                                    type="button"
                                    class="status-option"
                                    data-value="processing"
                                    role="option"
                                    aria-selected="false"
                                >
                                    Processing
                                </button>


                                <button
                                    type="button"
                                    class="status-option"
                                    data-value="shipped"
                                    role="option"
                                    aria-selected="false"
                                >
                                    Shipped
                                </button>


                                <button
                                    type="button"
                                    class="status-option"
                                    data-value="in_transit"
                                    role="option"
                                    aria-selected="false"
                                >
                                    In Transit
                                </button>


                                <button
                                    type="button"
                                    class="status-option"
                                    data-value="out_for_delivery"
                                    role="option"
                                    aria-selected="false"
                                >
                                    Out for Delivery
                                </button>


                                <button
                                    type="button"
                                    class="status-option"
                                    data-value="delivered"
                                    role="option"
                                    aria-selected="false"
                                >
                                    Delivered
                                </button>


                                <button
                                    type="button"
                                    class="status-option"
                                    data-value="completed"
                                    role="option"
                                    aria-selected="false"
                                >
                                    Completed
                                </button>


                                <button
                                    type="button"
                                    class="status-option"
                                    data-value="cancelled"
                                    role="option"
                                    aria-selected="false"
                                >
                                    Cancelled
                                </button>


                                <button
                                    type="button"
                                    class="status-option"
                                    data-value="failed"
                                    role="option"
                                    aria-selected="false"
                                >
                                    Failed
                                </button>


                                <button
                                    type="button"
                                    class="status-option"
                                    data-value="refund_pending"
                                    role="option"
                                    aria-selected="false"
                                >
                                    Refund Requested
                                </button>


                                <button
                                    type="button"
                                    class="status-option"
                                    data-value="refund_approved"
                                    role="option"
                                    aria-selected="false"
                                >
                                    Refund Approved
                                </button>


                                <button
                                    type="button"
                                    class="status-option"
                                    data-value="refund_rejected"
                                    role="option"
                                    aria-selected="false"
                                >
                                    Refund Rejected
                                </button>


                                <button
                                    type="button"
                                    class="status-option"
                                    data-value="refunded"
                                    role="option"
                                    aria-selected="false"
                                >
                                    Refunded
                                </button>

                            </div>


                            <input
                                type="hidden"
                                name="status"
                                value="all"
                                class="status-input"
                            >

                        </div>

                    </div>

                </div>

            </div>


            {{-- Orders Content --}}
            <div class="my-orders-page__content">

                <div class="my-orders-page__orders-header">

                    <div>

                        <span class="my-orders-page__section-label">
                            YOUR ORDERS
                        </span>

                        <h2>
                            Recent Orders
                        </h2>

                    </div>


                    <span class="my-orders-page__order-count">

                        {{ $orders->total() }}

                        {{ $orders->total() === 1 ? 'Order' : 'Orders' }}

                    </span>

                </div>


                <div class="my-orders-page__order-list">

                    @forelse($orders as $order)

                        @php
                            /*
                             |--------------------------------------------------------------------------
                             | Order Status
                             |--------------------------------------------------------------------------
                             |
                             | The order status now follows the complete delivery lifecycle:
                             |
                             | pending
                             | paid
                             | processing
                             | shipped
                             | in_transit
                             | out_for_delivery
                             | delivered
                             | completed
                             | cancelled
                             | failed
                             |
                             */

                            $orderStatus = match ($order->status) {
                                \App\Models\Order::STATUS_PAID => 'paid',

                                \App\Models\Order::STATUS_PROCESSING => 'processing',

                                \App\Models\Order::STATUS_SHIPPED => 'shipped',

                                \App\Models\Order::STATUS_IN_TRANSIT => 'in_transit',

                                \App\Models\Order::STATUS_OUT_FOR_DELIVERY => 'out_for_delivery',

                                \App\Models\Order::STATUS_DELIVERED => 'delivered',

                                \App\Models\Order::STATUS_COMPLETED => 'completed',

                                \App\Models\Order::STATUS_CANCELLED => 'cancelled',

                                \App\Models\Order::STATUS_FAILED => 'failed',

                                default => 'pending',
                            };


                            $orderStatusLabel = match ($orderStatus) {
                                'paid' => 'Paid',

                                'processing' => 'Processing',

                                'shipped' => 'Shipped',

                                'in_transit' => 'In Transit',

                                'out_for_delivery' => 'Out for Delivery',

                                'delivered' => 'Delivered',

                                'completed' => 'Completed',

                                'cancelled' => 'Cancelled',

                                'failed' => 'Failed',

                                default => 'Pending',
                            };


                            $orderStatusIcon = match ($orderStatus) {
                                'paid' => 'ri-checkbox-circle-line',

                                'processing' => 'ri-loader-4-line',

                                'shipped' => 'ri-box-3-line',

                                'in_transit' => 'ri-truck-line',

                                'out_for_delivery' => 'ri-map-pin-time-line',

                                'delivered' => 'ri-checkbox-circle-fill',

                                'completed' => 'ri-checkbox-circle-fill',

                                'cancelled' => 'ri-close-circle-line',

                                'failed' => 'ri-error-warning-line',

                                default => 'ri-time-line',
                            };


                            /*
                             |--------------------------------------------------------------------------
                             | Refund Status
                             |--------------------------------------------------------------------------
                             */

                            $refundStatus = $order->refund_status
                                ?? \App\Models\Order::REFUND_STATUS_NONE;


                            $refundStatusFilter = match ($refundStatus) {
                                \App\Models\Order::REFUND_STATUS_PENDING => 'refund_pending',

                                \App\Models\Order::REFUND_STATUS_APPROVED => 'refund_approved',

                                \App\Models\Order::REFUND_STATUS_REJECTED => 'refund_rejected',

                                \App\Models\Order::REFUND_STATUS_REFUNDED => 'refunded',

                                default => null,
                            };


                            $refundStatusLabel = match ($refundStatus) {
                                \App\Models\Order::REFUND_STATUS_PENDING => 'Refund Requested',

                                \App\Models\Order::REFUND_STATUS_APPROVED => 'Refund Approved',

                                \App\Models\Order::REFUND_STATUS_REJECTED => 'Refund Rejected',

                                \App\Models\Order::REFUND_STATUS_REFUNDED => 'Refunded',

                                default => null,
                            };


                            $refundStatusIcon = match ($refundStatus) {
                                \App\Models\Order::REFUND_STATUS_PENDING => 'ri-time-line',

                                \App\Models\Order::REFUND_STATUS_APPROVED => 'ri-checkbox-circle-line',

                                \App\Models\Order::REFUND_STATUS_REJECTED => 'ri-close-circle-line',

                                \App\Models\Order::REFUND_STATUS_REFUNDED => 'ri-refund-2-line',

                                default => null,
                            };


                            $refundStatusClass = match ($refundStatus) {
                                \App\Models\Order::REFUND_STATUS_PENDING => 'pending',

                                \App\Models\Order::REFUND_STATUS_APPROVED => 'approved',

                                \App\Models\Order::REFUND_STATUS_REJECTED => 'rejected',

                                \App\Models\Order::REFUND_STATUS_REFUNDED => 'refunded',

                                default => null,
                            };


                            /*
                             |--------------------------------------------------------------------------
                             | Delivery Status
                             |--------------------------------------------------------------------------
                             */

                            $deliveryIcon = match ($orderStatus) {
                                'paid' => 'ri-checkbox-circle-line',

                                'processing' => 'ri-loader-4-line',

                                'shipped' => 'ri-box-3-line',

                                'in_transit' => 'ri-truck-line',

                                'out_for_delivery' => 'ri-map-pin-time-line',

                                'delivered' => 'ri-map-pin-line',

                                'completed' => 'ri-checkbox-circle-fill',

                                'cancelled' => 'ri-close-circle-line',

                                'failed' => 'ri-error-warning-line',

                                default => 'ri-time-line',
                            };


                            $deliveryText = match ($orderStatus) {
                                'paid' => 'Payment received',

                                'processing' => 'Preparing your order',

                                'shipped' => 'Your order has been shipped',

                                'in_transit' => 'Your order is in transit',

                                'out_for_delivery' => 'Your order is out for delivery',

                                'delivered' => 'Your order has been delivered',

                                'completed' => 'Order completed',

                                'cancelled' => 'Order cancelled',

                                'failed' => 'There was an issue with your order',

                                default => 'Order is awaiting processing',
                            };
                        @endphp


                        <article
                            class="my-orders-page__order-card"
                            data-status="{{ $orderStatus }}"
                            data-refund-status="{{ $refundStatusFilter ?? 'none' }}"
                            data-order="{{ $order->order_number }}"
                        >

                            {{-- Order Top --}}
                            <div class="my-orders-page__order-top">

                                <div class="my-orders-page__order-info">

                                    <div class="my-orders-page__order-number">

                                        <span>
                                            Order
                                        </span>

                                        <strong>
                                            #{{ $order->order_number }}
                                        </strong>

                                    </div>


                                    <span class="my-orders-page__order-date">
                                        {{ $order->created_at->format('F j, Y') }}
                                    </span>

                                </div>


                                <div class="my-orders-page__status-group">

                                    <span
                                        class="my-orders-page__status my-orders-page__status--{{ $orderStatus }}"
                                    >
                                        <i class="{{ $orderStatusIcon }}"></i>

                                        {{ $orderStatusLabel }}
                                    </span>


                                    @if($refundStatusLabel)

                                        <span
                                            class="my-orders-page__refund-status my-orders-page__refund-status--{{ $refundStatusClass }}"
                                        >
                                            <i class="{{ $refundStatusIcon }}"></i>

                                            {{ $refundStatusLabel }}
                                        </span>

                                    @endif

                                </div>

                            </div>


                            {{-- Order Body --}}
                            <div class="my-orders-page__order-body">

                                <div class="my-orders-page__product-list">

                                    @foreach($order->items as $item)

                                        @php
                                            $product = $item->product;

                                            $category = $product?->categories?->first()?->name;

                                            $image = $item->image;

                                            $attributes = [];

                                            if ($item->variant?->values) {
                                                foreach ($item->variant->values as $value) {
                                                    $attributeName = $value->attribute?->name;
                                                    $valueName = $value->value ?? null;

                                                    if ($attributeName && $valueName) {
                                                        $attributes[] =
                                                            $attributeName . ': ' . $valueName;
                                                    }
                                                }
                                            }
                                        @endphp


                                        <div class="my-orders-page__product">

                                            <div class="my-orders-page__product-image">

                                                @if($image)

                                                    <img
                                                        src="{{ asset($image) }}"
                                                        alt="{{ $item->product_name }}"
                                                        loading="lazy"
                                                    >

                                                @else

                                                    <span>
                                                        No Image
                                                    </span>

                                                @endif

                                            </div>


                                            <div class="my-orders-page__product-info">

                                                @if($category)

                                                    <span class="my-orders-page__product-category">
                                                        {{ $category }}
                                                    </span>

                                                @endif


                                                <h3>
                                                    {{ $item->product_name }}
                                                </h3>


                                                <div class="my-orders-page__product-meta">

                                                    @foreach($attributes as $attribute)

                                                        <span>
                                                            {{ $attribute }}
                                                        </span>

                                                    @endforeach


                                                    <span>
                                                        Qty: {{ $item->quantity }}
                                                    </span>

                                                </div>

                                            </div>


                                            <strong class="my-orders-page__product-price">
                                                ${{ number_format((float) $item->line_total, 2) }}
                                            </strong>

                                        </div>

                                    @endforeach

                                </div>


                                {{-- Order Summary --}}
                                <div class="my-orders-page__order-summary">

                                    <span>
                                        {{ $order->items_count }}
                                        {{ $order->items_count === 1 ? 'Item' : 'Items' }}
                                    </span>

                                    <strong>
                                        ${{ number_format((float) $order->total, 2) }}
                                    </strong>

                                </div>


                                {{-- Refund Information --}}
                                @if($refundStatusLabel)

                                    <div
                                        class="my-orders-page__refund-info my-orders-page__refund-info--{{ $refundStatusClass }}"
                                    >

                                        <i class="{{ $refundStatusIcon }}"></i>

                                        <div>

                                            <strong>
                                                {{ $refundStatusLabel }}
                                            </strong>

                                            <span>

                                                @switch($refundStatus)

                                                    @case(\App\Models\Order::REFUND_STATUS_PENDING)

                                                        Your refund request is under review.

                                                        @break

                                                    @case(\App\Models\Order::REFUND_STATUS_APPROVED)

                                                        Your refund request has been approved and is being processed.

                                                        @break

                                                    @case(\App\Models\Order::REFUND_STATUS_REJECTED)

                                                        Your refund request was rejected. View order details for more information.

                                                        @break

                                                    @case(\App\Models\Order::REFUND_STATUS_REFUNDED)

                                                        Your refund has been successfully processed.

                                                        @break

                                                @endswitch

                                            </span>

                                        </div>

                                    </div>

                                @endif

                            </div>


                            {{-- Order Footer --}}
                            <div class="my-orders-page__order-footer">

                                <span class="my-orders-page__delivery">

                                    <i class="{{ $deliveryIcon }}"></i>

                                    {{ $deliveryText }}

                                </span>


                                <a
                                    href="{{ route('my-orders.show', $order->order_number) }}"
                                    class="my-orders-page__details-btn"
                                    data-order-number="{{ $order->order_number }}"
                                >
                                    View Details

                                    <i class="ri-arrow-right-line"></i>
                                </a>

                            </div>

                        </article>

                    @empty

                        <div class="my-orders-page__empty my-orders-page__empty--initial">

                            <div class="my-orders-page__empty-icon">
                                <i class="ri-file-list-3-line"></i>
                            </div>

                            <h3>
                                No orders yet
                            </h3>

                            <p>
                                You haven't placed any orders yet.
                            </p>

                            <a
                                href="{{ route('shop') }}"
                                class="my-orders-page__reset-btn"
                            >
                                Browse Products
                            </a>

                        </div>

                    @endforelse


                    {{-- Filter Empty State --}}
                    <div
                        class="my-orders-page__empty my-orders-page__empty--filter"
                        hidden
                    >

                        <div class="my-orders-page__empty-icon">
                            <i class="ri-search-line"></i>
                        </div>

                        <h3>
                            No orders found
                        </h3>

                        <p>
                            Try changing your search or order status filter.
                        </p>

                        <button
                            type="button"
                            class="my-orders-page__reset-btn"
                        >
                            Clear Filters
                        </button>

                    </div>

                </div>


                {{-- Pagination --}}
                {{ $orders->links('frontend.components.pagination') }}

            </div>


            {{-- Bottom CTA --}}
            <div class="my-orders-page__bottom-cta">

                <div>

                    <span>
                        Looking for something new?
                    </span>

                    <strong>
                        Explore our latest products.
                    </strong>

                </div>


                <a href="{{ route('shop') }}">

                    Browse Products

                    <i class="ri-arrow-right-line"></i>

                </a>

            </div>

        </div>

    </div>

@endsection


@push('scripts')

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const ordersPage = document.querySelector(".my-orders-page");

            if (!ordersPage) {
                return;
            }


            const searchInput = ordersPage.querySelector(
                ".my-orders-page__search-input",
            );


            const statusSelect = ordersPage.querySelector(
                ".status-select",
            );


            const statusTrigger = statusSelect?.querySelector(
                ".status-select-trigger",
            );


            const statusOptions = statusSelect
                ? Array.from(
                    statusSelect.querySelectorAll(".status-option"),
                )
                : [];


            const statusValue = statusSelect?.querySelector(
                ".status-select-value strong",
            );


            const statusInput = statusSelect?.querySelector(
                ".status-input",
            );


            const orderCards = Array.from(
                ordersPage.querySelectorAll(
                    ".my-orders-page__order-card",
                ),
            );


            const filterEmpty = ordersPage.querySelector(
                ".my-orders-page__empty--filter",
            );


            const resetButton = ordersPage.querySelector(
                ".my-orders-page__empty--filter .my-orders-page__reset-btn",
            );


            const refundStatuses = [
                "refund_pending",
                "refund_approved",
                "refund_rejected",
                "refunded",
            ];


            const filterOrders = function () {

                const searchValue = searchInput
                    ? searchInput.value.trim().toLowerCase()
                    : "";


                const selectedStatus = statusInput
                    ? statusInput.value
                    : "all";


                let visibleOrders = 0;


                orderCards.forEach(function (orderCard) {

                    const orderNumber = (
                        orderCard.dataset.order || ""
                    ).toLowerCase();


                    const orderText =
                        orderCard.textContent.toLowerCase();


                    const orderStatus = (
                        orderCard.dataset.status || ""
                    ).toLowerCase();


                    const refundStatus = (
                        orderCard.dataset.refundStatus || ""
                    ).toLowerCase();


                    const matchesSearch =
                        searchValue === ""
                        || orderNumber.includes(searchValue)
                        || orderText.includes(searchValue);


                    let matchesStatus = true;


                    if (selectedStatus !== "all") {

                        if (
                            refundStatuses.includes(
                                selectedStatus,
                            )
                        ) {
                            matchesStatus =
                                refundStatus === selectedStatus;
                        } else {
                            matchesStatus =
                                orderStatus === selectedStatus;
                        }

                    }


                    const shouldShow =
                        matchesSearch && matchesStatus;


                    orderCard.hidden = !shouldShow;


                    if (shouldShow) {
                        visibleOrders++;
                    }

                });


                if (filterEmpty) {

                    filterEmpty.hidden =
                        visibleOrders !== 0;

                }

            };


            const closeStatusDropdown = function () {

                if (!statusSelect) {
                    return;
                }


                statusSelect.classList.remove(
                    "is-open",
                );


                if (statusTrigger) {

                    statusTrigger.setAttribute(
                        "aria-expanded",
                        "false",
                    );

                }

            };


            const resetFilters = function () {

                if (searchInput) {
                    searchInput.value = "";
                }


                if (statusInput) {
                    statusInput.value = "all";
                }


                if (statusValue) {
                    statusValue.textContent = "All Orders";
                }


                statusOptions.forEach(function (option) {

                    const isSelected =
                        option.dataset.value === "all";


                    option.classList.toggle(
                        "is-selected",
                        isSelected,
                    );


                    option.setAttribute(
                        "aria-selected",
                        isSelected
                            ? "true"
                            : "false",
                    );

                });


                closeStatusDropdown();

                filterOrders();

            };


            if (searchInput) {

                searchInput.addEventListener(
                    "input",
                    filterOrders,
                );

            }


            if (statusTrigger && statusSelect) {

                statusTrigger.addEventListener(
                    "click",
                    function (event) {

                        event.stopPropagation();


                        const isOpen =
                            statusSelect.classList.contains(
                                "is-open",
                            );


                        if (isOpen) {

                            closeStatusDropdown();

                            return;

                        }


                        statusSelect.classList.add(
                            "is-open",
                        );


                        statusTrigger.setAttribute(
                            "aria-expanded",
                            "true",
                        );

                    },
                );

            }


            statusOptions.forEach(function (option) {

                option.addEventListener(
                    "click",
                    function (event) {

                        event.stopPropagation();


                        const value =
                            option.dataset.value || "all";


                        const text =
                            option.textContent.trim();


                        if (statusInput) {

                            statusInput.value = value;

                        }


                        if (statusValue) {

                            statusValue.textContent = text;

                        }


                        statusOptions.forEach(
                            function (item) {

                                const isSelected =
                                    item === option;


                                item.classList.toggle(
                                    "is-selected",
                                    isSelected,
                                );


                                item.setAttribute(
                                    "aria-selected",
                                    isSelected
                                        ? "true"
                                        : "false",
                                );

                            },
                        );


                        closeStatusDropdown();

                        filterOrders();

                    },
                );

            });


            document.addEventListener(
                "click",
                function (event) {

                    if (
                        statusSelect
                        && !statusSelect.contains(
                            event.target,
                        )
                    ) {
                        closeStatusDropdown();
                    }

                },
            );


            if (resetButton) {

                resetButton.addEventListener(
                    "click",
                    resetFilters,
                );

            }


            filterOrders();

        });
    </script>

@endpush
