@extends('backend.layouts.backend')

@section('title', 'Order Details')

@section('content')

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

        $customerInitials = $customerInitials ?: '?';

        /*
        |--------------------------------------------------------------------------
        | Refund Status
        |--------------------------------------------------------------------------
        */

        $refundStatus = $order->refund_status
            ?? \App\Models\Order::REFUND_STATUS_NONE;

        $refundStatusOverview = match ($refundStatus) {
            \App\Models\Order::REFUND_STATUS_PENDING => [
                'label' => 'Refund Requested',
                'class' => 'refund-pending',
                'icon' => 'ri-time-line',
            ],
            \App\Models\Order::REFUND_STATUS_APPROVED => [
                'label' => 'Refund Approved',
                'class' => 'refund-approved',
                'icon' => 'ri-checkbox-circle-line',
            ],
            \App\Models\Order::REFUND_STATUS_REJECTED => [
                'label' => 'Refund Rejected',
                'class' => 'refund-rejected',
                'icon' => 'ri-close-circle-line',
            ],
            \App\Models\Order::REFUND_STATUS_REFUNDED => [
                'label' => 'Refunded',
                'class' => 'refunded',
                'icon' => 'ri-refund-2-line',
            ],
            default => null,
        };

        /*
        |--------------------------------------------------------------------------
        | Order Status
        |--------------------------------------------------------------------------
        */

        $orderStatusOverview = match ($order->status) {
            \App\Models\Order::STATUS_PENDING => [
                'label' => 'Pending',
                'class' => 'pending',
                'icon' => 'ri-time-line',
            ],
            \App\Models\Order::STATUS_PAID => [
                'label' => 'Paid',
                'class' => 'paid',
                'icon' => 'ri-checkbox-circle-line',
            ],
            \App\Models\Order::STATUS_PROCESSING => [
                'label' => 'Processing',
                'class' => 'processing',
                'icon' => 'ri-loader-4-line',
            ],
            \App\Models\Order::STATUS_COMPLETED => [
                'label' => 'Completed',
                'class' => 'completed',
                'icon' => 'ri-file-list-3-line',
            ],
            \App\Models\Order::STATUS_CANCELLED => [
                'label' => 'Cancelled',
                'class' => 'cancelled',
                'icon' => 'ri-close-circle-line',
            ],
            \App\Models\Order::STATUS_FAILED => [
                'label' => 'Failed',
                'class' => 'failed',
                'icon' => 'ri-error-warning-line',
            ],
            default => [
                'label' => ucfirst($order->status),
                'class' => 'pending',
                'icon' => 'ri-information-line',
            ],
        };

        /*
        |--------------------------------------------------------------------------
        | Displayed Order Status
        |--------------------------------------------------------------------------
        |
        | Refund status takes visual priority over normal order status.
        | The actual order->status remains unchanged.
        |
        */

        $displayStatus = $refundStatusOverview ?? $orderStatusOverview;

        /*
        |--------------------------------------------------------------------------
        | Payment Status
        |--------------------------------------------------------------------------
        */

        $paymentClass = match ($order->payment_status) {
            \App\Models\Order::PAYMENT_STATUS_PAID => 'paid',
            \App\Models\Order::PAYMENT_STATUS_PENDING => 'pending',
            \App\Models\Order::PAYMENT_STATUS_FAILED => 'failed',
            \App\Models\Order::PAYMENT_STATUS_REFUNDED => 'refunded',
            default => 'pending',
        };

        /*
        |--------------------------------------------------------------------------
        | Shipment Status
        |--------------------------------------------------------------------------
        */

        $shipmentStatus = match ($order->shipment?->status) {
            \App\Models\Shipment::STATUS_PENDING => 'Pending',
            \App\Models\Shipment::STATUS_PROCESSING => 'Processing',
            \App\Models\Shipment::STATUS_SHIPPED => 'Shipped',
            \App\Models\Shipment::STATUS_CANCELLED => 'Cancelled',
            default => 'Not Shipped',
        };

        /*
        |--------------------------------------------------------------------------
        | Shipment Status Overview
        |--------------------------------------------------------------------------
        */

        $shipmentOverview = match ($order->shipment?->status) {
            \App\Models\Shipment::STATUS_PENDING => [
                'label' => 'Pending',
                'class' => 'pending',
                'icon' => 'ri-time-line',
            ],
            \App\Models\Shipment::STATUS_PROCESSING => [
                'label' => 'Processing',
                'class' => 'processing',
                'icon' => 'ri-loader-4-line',
            ],
            \App\Models\Shipment::STATUS_SHIPPED => [
                'label' => 'Shipped',
                'class' => 'shipped',
                'icon' => 'ri-truck-line',
            ],
            \App\Models\Shipment::STATUS_CANCELLED => [
                'label' => 'Cancelled',
                'class' => 'cancelled',
                'icon' => 'ri-close-circle-line',
            ],
            default => [
                'label' => 'Not Created',
                'class' => 'pending',
                'icon' => 'ri-truck-line',
            ],
        };

        /*
        |--------------------------------------------------------------------------
        | Delivery Status Overview
        |--------------------------------------------------------------------------
        */

        $deliveryOverview = match ($order->shipment?->delivery_status) {
            \App\Models\Shipment::DELIVERY_STATUS_PENDING => [
                'label' => 'Pending',
                'class' => 'pending',
                'icon' => 'ri-time-line',
            ],
            \App\Models\Shipment::DELIVERY_STATUS_IN_TRANSIT => [
                'label' => 'In Transit',
                'class' => 'in-transit',
                'icon' => 'ri-truck-line',
            ],
            \App\Models\Shipment::DELIVERY_STATUS_OUT_FOR_DELIVERY => [
                'label' => 'Out for Delivery',
                'class' => 'out-for-delivery',
                'icon' => 'ri-map-pin-time-line',
            ],
            \App\Models\Shipment::DELIVERY_STATUS_DELIVERED => [
                'label' => 'Delivered',
                'class' => 'delivered',
                'icon' => 'ri-checkbox-circle-line',
            ],
            \App\Models\Shipment::DELIVERY_STATUS_FAILED => [
                'label' => 'Failed',
                'class' => 'failed',
                'icon' => 'ri-error-warning-line',
            ],
            default => [
                'label' => 'Not Shipped',
                'class' => 'pending',
                'icon' => 'ri-truck-line',
            ],
        };

        /*
        |--------------------------------------------------------------------------
        | Payment Overview
        |--------------------------------------------------------------------------
        */

        $paymentOverview = match ($order->payment_status) {
            \App\Models\Order::PAYMENT_STATUS_PAID => [
                'label' => 'Paid',
                'class' => 'paid',
                'icon' => 'ri-checkbox-circle-line',
            ],
            \App\Models\Order::PAYMENT_STATUS_PENDING => [
                'label' => 'Pending',
                'class' => 'pending',
                'icon' => 'ri-time-line',
            ],
            \App\Models\Order::PAYMENT_STATUS_FAILED => [
                'label' => 'Failed',
                'class' => 'failed',
                'icon' => 'ri-error-warning-line',
            ],
            \App\Models\Order::PAYMENT_STATUS_REFUNDED => [
                'label' => 'Refunded',
                'class' => 'refunded',
                'icon' => 'ri-refund-2-line',
            ],
            default => [
                'label' => ucfirst($order->payment_status),
                'class' => 'pending',
                'icon' => 'ri-information-line',
            ],
        };

        /*
        |--------------------------------------------------------------------------
        | Shipment Availability
        |--------------------------------------------------------------------------
        */

        $isPaymentPaid = $order->payment_status
            === \App\Models\Order::PAYMENT_STATUS_PAID;

        $hasShipment = $order->shipment !== null;

        /*
        |--------------------------------------------------------------------------
        | Currency
        |--------------------------------------------------------------------------
        */

        $currency = strtoupper((string) $order->currency);

        $currencySymbol = match ($currency) {
            'EUR' => '€',
            'GBP' => '£',
            'CAD' => 'CA$',
            'AUD' => 'A$',
            default => '$',
        };
    @endphp

    <div class="order-details-page">

        {{-- ================================================================ --}}
        {{-- PAGE HEADER --}}
        {{-- ================================================================ --}}

        <div class="order-details-page__header">

            <div>

                <a
                    href="{{ route('admin-orders') }}"
                    class="order-details-back"
                >
                    <i class="ri-arrow-left-line"></i>

                    Back to Orders
                </a>

                <div class="order-details-title">

                    <div>

                        <span class="order-details-page__eyebrow">
                            Ecommerce / Orders
                        </span>

                        <h1>
                            Order #{{ $order->order_number }}
                        </h1>

                        <p>
                            Placed on
                            {{ $order->created_at?->format('F d, Y \a\t h:i A') }}
                        </p>

                    </div>

                    <span
                        class="order-details-main-status order-details-main-status--{{ $displayStatus['class'] }}"
                    >
                        <i class="{{ $displayStatus['icon'] }}"></i>

                        {{ $displayStatus['label'] }}
                    </span>

                </div>

            </div>

            <div class="order-details-page__actions">

                <button
                    type="button"
                    class="order-details-action-btn"
                    data-print-order
                >
                    <i class="ri-printer-line"></i>

                    Print
                </button>

                <button
                    type="button"
                    class="order-details-action-btn order-details-action-btn--primary"
                    data-open-status-modal
                >
                    <i class="ri-edit-line"></i>

                    Update Order
                </button>

            </div>

        </div>


        {{-- ================================================================ --}}
        {{-- STATUS OVERVIEW --}}
        {{-- ================================================================ --}}

        <section class="order-details-page__status-overview">

            {{-- Order Status --}}

            <div class="order-details-page__status-overview-item">

                <span>
                    Order Status
                </span>

                <strong
                    class="order-details-page__status order-details-page__status--{{ $displayStatus['class'] }}"
                >
                    <i class="{{ $displayStatus['icon'] }}"></i>

                    {{ $displayStatus['label'] }}
                </strong>

            </div>


            {{-- Shipment Status --}}

            <div class="order-details-page__status-overview-item">

                <span>
                    Shipment Status
                </span>

                <strong
                    class="order-details-page__status order-details-page__status--{{ $shipmentOverview['class'] }}"
                >
                    <i class="{{ $shipmentOverview['icon'] }}"></i>

                    {{ $shipmentOverview['label'] }}
                </strong>

            </div>


            {{-- Delivery Status --}}

            <div class="order-details-page__status-overview-item">

                <span>
                    Delivery Status
                </span>

                <strong
                    class="order-details-page__status order-details-page__status--{{ $deliveryOverview['class'] }}"
                >
                    <i class="{{ $deliveryOverview['icon'] }}"></i>

                    {{ $deliveryOverview['label'] }}
                </strong>

            </div>


            {{-- Payment --}}

            <div class="order-details-page__status-overview-item">

                <span>
                    Payment
                </span>

                <strong
                    class="order-details-page__status order-details-page__status--{{ $paymentOverview['class'] }}"
                >
                    <i class="{{ $paymentOverview['icon'] }}"></i>

                    {{ $paymentOverview['label'] }}
                </strong>

            </div>

        </section>


        {{-- ================================================================ --}}
        {{-- ORDER SUMMARY --}}
        {{-- ================================================================ --}}

        <div class="order-details-summary">

            <div class="order-details-summary__item">

                <span>
                    Order Total
                </span>

                <strong>
                    {{ $currencySymbol }}{{ number_format((float) $order->total, 2) }}
                </strong>

            </div>

            <div class="order-details-summary__item">

                <span>
                    Items
                </span>

                <strong>
                    {{ number_format($order->items->sum('quantity')) }}
                </strong>

            </div>

            <div class="order-details-summary__item">

                <span>
                    Payment
                </span>

                <strong class="order-details-summary__paid">
                    {{ ucfirst($order->payment_status) }}
                </strong>

            </div>

            <div class="order-details-summary__item">

                <span>
                    Shipment
                </span>

                <strong>
                    {{ $shipmentStatus }}
                </strong>

            </div>

        </div>


        {{-- ================================================================ --}}
        {{-- MAIN GRID --}}
        {{-- ================================================================ --}}

        <div class="order-details-grid">

            {{-- ============================================================ --}}
            {{-- LEFT COLUMN --}}
            {{-- ============================================================ --}}

            <div class="order-details-main">

                {{-- ======================================================== --}}
                {{-- ORDER ITEMS --}}
                {{-- ======================================================== --}}

                <div class="order-details-card">

                    <div class="order-details-card__header">

                        <div>

                            <h2>
                                Order Items
                            </h2>

                            <span>
                                {{ $order->items->sum('quantity') }}
                                {{ $order->items->sum('quantity') === 1 ? 'product' : 'products' }}
                                in this order
                            </span>

                        </div>

                    </div>

                    <div class="order-items-table-wrapper">

                        <table class="order-items-table">

                            <thead>

                            <tr>

                                <th>
                                    Product
                                </th>

                                <th>
                                    Price
                                </th>

                                <th>
                                    Quantity
                                </th>

                                <th>
                                    Total
                                </th>

                            </tr>

                            </thead>

                            <tbody>

                            @forelse ($order->items as $item)

                                <tr>

                                    <td>

                                        <div class="order-product">

                                            <div class="order-product__image">

                                                @if ($item->image)

                                                    <img
                                                        src="{{ asset($item->image) }}"
                                                        alt="{{ $item->product_name }}"
                                                    >

                                                @else

                                                    <div class="order-product__placeholder">
                                                        <i class="ri-image-line"></i>
                                                    </div>

                                                @endif

                                            </div>

                                            <div class="order-product__content">

                                                <strong>
                                                    {{ $item->product_name }}
                                                </strong>

                                                @if ($item->sku)

                                                    <span>
                                                        SKU: {{ $item->sku }}
                                                    </span>

                                                @endif

                                            </div>

                                        </div>

                                    </td>

                                    <td>

                                        <strong>
                                            {{ $currencySymbol }}{{ number_format((float) $item->unit_price, 2) }}
                                        </strong>

                                    </td>

                                    <td>

                                        <span class="order-item-quantity">
                                            {{ $item->quantity }}
                                        </span>

                                    </td>

                                    <td>

                                        <strong>
                                            {{ $currencySymbol }}{{ number_format((float) $item->line_total, 2) }}
                                        </strong>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="4"
                                        class="order-items-empty"
                                    >
                                        No items found for this order.
                                    </td>

                                </tr>

                            @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>


                {{-- ======================================================== --}}
                {{-- ORDER SUMMARY --}}
                {{-- ======================================================== --}}

                <div class="order-details-card">

                    <div class="order-details-card__header">

                        <div>

                            <h2>
                                Order Summary
                            </h2>

                        </div>

                    </div>

                    <div class="order-total-list">

                        <div class="order-total-row">

                            <span>
                                Subtotal
                            </span>

                            <strong>
                                {{ $currencySymbol }}{{ number_format((float) $order->subtotal, 2) }}
                            </strong>

                        </div>

                        @if ((float) $order->discount > 0)

                            <div class="order-total-row">

                                <span>
                                    Discount
                                </span>

                                <strong class="order-total-discount">
                                    -{{ $currencySymbol }}{{ number_format((float) $order->discount, 2) }}
                                </strong>

                            </div>

                        @endif

                        <div class="order-total-row">

                            <span>
                                Shipping
                            </span>

                            <strong>
                                {{ $currencySymbol }}{{ number_format((float) $order->shipping, 2) }}
                            </strong>

                        </div>

                        <div class="order-total-row">

                            <span>
                                Tax
                            </span>

                            <strong>
                                {{ $currencySymbol }}{{ number_format((float) $order->tax, 2) }}
                            </strong>

                        </div>

                        <div class="order-total-row order-total-row--grand">

                            <span>
                                Total
                            </span>

                            <strong>
                                {{ $currencySymbol }}{{ number_format((float) $order->total, 2) }}
                            </strong>

                        </div>

                    </div>

                </div>


                {{-- ======================================================== --}}
                {{-- SHIPMENT --}}
                {{-- ======================================================== --}}

                <div class="order-details-card">

                    <div class="order-details-card__header">

                        <div>

                            <h2>
                                Ecommerce Shipment
                            </h2>

                            <span>
                                Shipment information for this order
                            </span>

                        </div>

                        @if ($hasShipment)

                            <span class="order-shipment-status order-shipment-status--pending">

                                <i></i>

                                {{ $shipmentStatus }}

                            </span>

                        @elseif ($isPaymentPaid)

                            <span class="order-shipment-status order-shipment-status--pending">

                                <i></i>

                                Ready to Ship

                            </span>

                        @else

                            <span class="order-shipment-status order-shipment-status--pending">

                                <i></i>

                                Payment Required

                            </span>

                        @endif

                    </div>

                    <div class="order-shipment-box">

                        <div class="order-shipment-info">

                            <span>
                                Carrier
                            </span>

                            <strong>
                                {{ $order->shipment?->carrier ?: '—' }}
                            </strong>

                        </div>

                        <div class="order-shipment-info">

                            <span>
                                Tracking Number
                            </span>

                            <strong>
                                {{ $order->shipment?->tracking_number ?: '—' }}
                            </strong>

                        </div>

                        <div class="order-shipment-info">

                            <span>
                                Shipment Status
                            </span>

                            <strong>
                                {{ $order->shipment?->status
                                    ? ucfirst(str_replace('_', ' ', $order->shipment->status))
                                    : 'Not Created'
                                }}
                            </strong>

                        </div>

                        <div class="order-shipment-info">

                            <span>
                                Delivery Status
                            </span>

                            <strong>
                                @if ($order->shipment?->delivery_status)
                                    {{ ucfirst(str_replace('_', ' ', $order->shipment->delivery_status)) }}
                                @else
                                    Not Shipped
                                @endif
                            </strong>

                        </div>

                    </div>

                    <div class="order-shipment-action">

                        @if ($isPaymentPaid && !$hasShipment)

                            <a
                                href="{{ route('ecommerce-shipments.create', ['order' => $order]) }}"
                                class="order-details-secondary-btn order-details-secondary-btn--primary"
                            >
                                <i class="ri-truck-line"></i>

                                Create Shipment
                            </a>

                        @elseif ($hasShipment)

                            <a
                                href="{{ route('ecommerce-shipments.show', ['shipment' => $order->shipment]) }}"
                                class="order-details-secondary-btn"
                            >
                                <i class="ri-truck-line"></i>

                                Manage Shipment
                            </a>

                        @else

                            <span class="order-details-secondary-btn order-details-secondary-btn--disabled">

                                <i class="ri-lock-line"></i>

                                Payment Required

                            </span>

                        @endif

                    </div>

                </div>

            </div>


            {{-- ============================================================ --}}
            {{-- RIGHT COLUMN --}}
            {{-- ============================================================ --}}

            <div class="order-details-sidebar">

                {{-- ======================================================== --}}
                {{-- CUSTOMER --}}
                {{-- ======================================================== --}}

                <div class="order-details-card">

                    <div class="order-details-card__header">

                        <h2>
                            Customer
                        </h2>

                    </div>

                    <div class="order-customer-profile">

                        <div class="order-customer-profile__avatar">
                            {{ $customerInitials }}
                        </div>

                        <div>

                            <strong>
                                {{ $customerName ?: 'Customer' }}
                            </strong>

                            <span>
                                Customer
                            </span>

                        </div>

                    </div>

                    <div class="order-customer-contact">

                        @if ($order->email)

                            <div>

                                <i class="ri-mail-line"></i>

                                <span>
                                    {{ $order->email }}
                                </span>

                            </div>

                        @endif

                        @if ($order->phone)

                            <div>

                                <i class="ri-phone-line"></i>

                                <span>
                                    {{ $order->phone }}
                                </span>

                            </div>

                        @endif

                    </div>

                </div>


                {{-- ======================================================== --}}
                {{-- SHIPPING ADDRESS --}}
                {{-- ======================================================== --}}

                <div class="order-details-card">

                    <div class="order-details-card__header">

                        <h2>
                            Shipping Address
                        </h2>

                    </div>

                    <div class="order-address">

                        <strong>
                            {{ $customerName }}
                        </strong>

                        @if ($order->address)

                            <span>
                                {{ $order->address }}
                            </span>

                        @endif

                        @if ($order->apartment)

                            <span>
                                {{ $order->apartment }}
                            </span>

                        @endif

                        <span>

                            {{ $order->city }}

                            @if ($order->state)
                                , {{ $order->state }}
                            @endif

                            {{ $order->postal_code }}

                        </span>

                        <span>
                            {{ $order->country }}
                        </span>

                    </div>

                </div>


                {{-- ======================================================== --}}
                {{-- BILLING ADDRESS --}}
                {{-- ======================================================== --}}

                <div class="order-details-card">

                    <div class="order-details-card__header">

                        <h2>
                            Billing Address
                        </h2>

                    </div>

                    <div class="order-address">

                        <strong>
                            {{ $customerName }}
                        </strong>

                        @if ($order->address)

                            <span>
                                {{ $order->address }}
                            </span>

                        @endif

                        @if ($order->apartment)

                            <span>
                                {{ $order->apartment }}
                            </span>

                        @endif

                        <span>

                            {{ $order->city }}

                            @if ($order->state)
                                , {{ $order->state }}
                            @endif

                            {{ $order->postal_code }}

                        </span>

                        <span>
                            {{ $order->country }}
                        </span>

                    </div>

                </div>


                {{-- ======================================================== --}}
                {{-- PAYMENT --}}
                {{-- ======================================================== --}}

                <div class="order-details-card">

                    <div class="order-details-card__header">

                        <h2>
                            Payment
                        </h2>

                    </div>

                    <div class="order-payment-details">

                        <div>

                            <span>
                                Payment Status
                            </span>

                            <span
                                class="order-payment-status order-payment-status--{{ $paymentClass }}"
                            >
                                <i></i>

                                {{ ucfirst($order->payment_status) }}

                            </span>

                        </div>

                        <div>

                            <span>
                                Method
                            </span>

                            <strong>
                                {{ ucfirst($order->payment_gateway ?: '—') }}
                            </strong>

                        </div>

                        <div>

                            <span>
                                Transaction
                            </span>

                            <strong>
                                {{ $order->stripe_payment_intent_id ?: '—' }}
                            </strong>

                        </div>

                        <div>

                            <span>
                                Amount
                            </span>

                            <strong>
                                {{ $currencySymbol }}{{ number_format((float) $order->total, 2) }}
                            </strong>

                        </div>

                        @if ($order->paid_at)

                            <div>

                                <span>
                                    Paid At
                                </span>

                                <strong>
                                    {{ $order->paid_at->format('M d, Y h:i A') }}
                                </strong>

                            </div>

                        @endif

                    </div>

                </div>


                {{-- ======================================================== --}}
                {{-- REFUND STATUS --}}
                {{-- ======================================================== --}}

                @if ($refundStatusOverview !== null)

                    <div class="order-details-card">

                        <div class="order-details-card__header">

                            <div>

                                <h2>
                                    Refund
                                </h2>

                                <span>
                                    Refund status for this order
                                </span>

                            </div>

                        </div>

                        <div class="order-refund-status">

                            <div
                                class="order-refund-status__badge order-refund-status__badge--{{ $refundStatusOverview['class'] }}"
                            >
                                <i class="{{ $refundStatusOverview['icon'] }}"></i>

                                {{ $refundStatusOverview['label'] }}
                            </div>

                        </div>

                    </div>

                @endif


                {{-- ======================================================== --}}
                {{-- ORDER NOTES --}}
                {{-- ======================================================== --}}

                @if ($order->notes)

                    <div class="order-details-card">

                        <div class="order-details-card__header">

                            <h2>
                                Order Notes
                            </h2>

                        </div>

                        <div class="order-note">

                            <i class="ri-information-line"></i>

                            <p>
                                {{ $order->notes }}
                            </p>

                        </div>

                    </div>

                @endif

            </div>

        </div>


        {{-- ================================================================ --}}
        {{-- UPDATE ORDER MODAL --}}
        {{-- ================================================================ --}}

        <div
            class="order-status-modal"
            data-status-modal
            aria-hidden="true"
        >

            <div
                class="order-status-modal__overlay"
                data-close-status-modal
            ></div>

            <div
                class="order-status-modal__dialog"
                role="dialog"
                aria-modal="true"
                aria-labelledby="order-status-modal-title"
            >

                <div class="order-status-modal__header">

                    <div>

                        <span class="order-status-modal__eyebrow">
                            Order #{{ $order->order_number }}
                        </span>

                        <h2 id="order-status-modal-title">
                            Update Order Status
                        </h2>

                    </div>

                    <button
                        type="button"
                        class="order-status-modal__close"
                        data-close-status-modal
                        aria-label="Close"
                    >
                        <i class="ri-close-line"></i>
                    </button>

                </div>

                <form
                    action="{{ route('admin-order-status', ['order' => $order]) }}"
                    method="POST"
                    data-status-form
                >

                    @csrf

                    @method('PATCH')

                    <div class="order-status-modal__body">

                        <label for="order-status">
                            Order Status
                        </label>

                        <select
                            id="order-status"
                            name="status"
                            data-status-select
                        >

                            @foreach ([
                                \App\Models\Order::STATUS_PENDING,
                                \App\Models\Order::STATUS_PAID,
                                \App\Models\Order::STATUS_PROCESSING,
                                \App\Models\Order::STATUS_COMPLETED,
                                \App\Models\Order::STATUS_CANCELLED,
                                \App\Models\Order::STATUS_FAILED,
                            ] as $orderStatus)

                                <option
                                    value="{{ $orderStatus }}"
                                    @selected($order->status === $orderStatus)
                                >
                                    {{ ucfirst($orderStatus) }}
                                </option>

                            @endforeach

                        </select>

                        <div class="order-status-modal__current">

                            <span>
                                Current Status
                            </span>

                            <strong>
                                {{ ucfirst($order->status) }}
                            </strong>

                        </div>

                        @if ($refundStatusOverview !== null)

                            <div class="order-status-modal__warning">

                                <i class="{{ $refundStatusOverview['icon'] }}"></i>

                                <span>
                                    This order currently has a
                                    {{ strtolower($refundStatusOverview['label']) }}
                                    refund status.
                                </span>

                            </div>

                        @endif

                        <div
                            class="order-status-modal__warning"
                            data-status-warning
                            hidden
                        >
                            <i class="ri-error-warning-line"></i>

                            <span>
                                Changing the order to Cancelled should only be
                                done when the order has not already been
                                fulfilled.
                            </span>

                        </div>

                    </div>

                    <div class="order-status-modal__footer">

                        <button
                            type="button"
                            class="order-status-modal__cancel"
                            data-close-status-modal
                        >
                            Cancel
                        </button>

                        <button
                            type="submit"
                            class="order-status-modal__submit"
                            data-status-submit
                        >
                            <i class="ri-check-line"></i>

                            Update Status
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

@endsection

@push('scripts')

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const orderPage = document.querySelector(
                ".order-details-page",
            );

            if (!orderPage) {
                return;
            }

            const printButton = orderPage.querySelector(
                "[data-print-order]",
            );

            const openStatusButton = orderPage.querySelector(
                "[data-open-status-modal]",
            );

            const statusModal = orderPage.querySelector(
                "[data-status-modal]",
            );

            const closeStatusButtons = orderPage.querySelectorAll(
                "[data-close-status-modal]",
            );

            const statusForm = orderPage.querySelector(
                "[data-status-form]",
            );

            const statusSelect = orderPage.querySelector(
                "[data-status-select]",
            );

            const statusSubmit = orderPage.querySelector(
                "[data-status-submit]",
            );

            const statusWarning = orderPage.querySelector(
                "[data-status-warning]",
            );

            const currentStatus = statusSelect?.value || "";

            const openModal = function () {
                if (!statusModal) {
                    return;
                }

                statusModal.removeAttribute("aria-hidden");

                statusModal.classList.add("is-open");

                document.body.classList.add(
                    "order-status-modal-open",
                );

                window.setTimeout(function () {
                    statusSelect?.focus();
                }, 50);
            };

            const closeModal = function () {
                if (!statusModal) {
                    return;
                }

                statusModal.setAttribute(
                    "aria-hidden",
                    "true",
                );

                statusModal.classList.remove("is-open");

                document.body.classList.remove(
                    "order-status-modal-open",
                );
            };

            const updateWarning = function () {
                if (!statusWarning || !statusSelect) {
                    return;
                }

                statusWarning.hidden =
                    statusSelect.value !== "cancelled";
            };

            printButton?.addEventListener(
                "click",
                function () {
                    window.print();
                },
            );

            openStatusButton?.addEventListener(
                "click",
                openModal,
            );

            closeStatusButtons.forEach(function (button) {
                button.addEventListener(
                    "click",
                    closeModal,
                );
            });

            statusSelect?.addEventListener(
                "change",
                updateWarning,
            );

            statusForm?.addEventListener(
                "submit",
                function (event) {
                    if (
                        statusSelect
                        && statusSelect.value === currentStatus
                    ) {
                        event.preventDefault();

                        closeModal();

                        return;
                    }

                    if (!statusSubmit) {
                        return;
                    }

                    statusSubmit.disabled = true;

                    statusSubmit.innerHTML =
                        '<i class="ri-loader-4-line"></i> Updating...';
                },
            );

            document.addEventListener(
                "keydown",
                function (event) {
                    if (
                        event.key === "Escape"
                        && statusModal?.classList.contains("is-open")
                    ) {
                        closeModal();
                    }
                },
            );

            updateWarning();
        });
    </script>

@endpush
