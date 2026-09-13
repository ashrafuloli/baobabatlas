@extends('backend.layouts.backend')

@section('title', 'Shipment Details')

@php
    use App\Models\Shipment;

    $shipmentStatus = match ($shipment->status) {
        Shipment::STATUS_PENDING => [
            'label' => 'Pending',
            'class' => 'pending',
            'icon' => 'ri-time-line',
        ],

        Shipment::STATUS_PROCESSING => [
            'label' => 'Processing',
            'class' => 'processing',
            'icon' => 'ri-loader-4-line',
        ],

        Shipment::STATUS_SHIPPED => [
            'label' => 'Shipped',
            'class' => 'shipped',
            'icon' => 'ri-truck-line',
        ],

        Shipment::STATUS_CANCELLED => [
            'label' => 'Cancelled',
            'class' => 'cancelled',
            'icon' => 'ri-close-circle-line',
        ],

        default => [
            'label' => ucfirst($shipment->status),
            'class' => 'pending',
            'icon' => 'ri-information-line',
        ],
    };

    $deliveryStatus = match ($shipment->delivery_status) {
        Shipment::DELIVERY_STATUS_PENDING => [
            'label' => 'Pending',
            'class' => 'pending',
            'icon' => 'ri-time-line',
        ],

        Shipment::DELIVERY_STATUS_IN_TRANSIT => [
            'label' => 'In Transit',
            'class' => 'in-transit',
            'icon' => 'ri-truck-line',
        ],

        Shipment::DELIVERY_STATUS_OUT_FOR_DELIVERY => [
            'label' => 'Out for Delivery',
            'class' => 'out-for-delivery',
            'icon' => 'ri-map-pin-time-line',
        ],

        Shipment::DELIVERY_STATUS_DELIVERED => [
            'label' => 'Delivered',
            'class' => 'delivered',
            'icon' => 'ri-checkbox-circle-line',
        ],

        Shipment::DELIVERY_STATUS_FAILED => [
            'label' => 'Failed',
            'class' => 'failed',
            'icon' => 'ri-error-warning-line',
        ],

        default => [
            'label' => ucfirst($shipment->delivery_status),
            'class' => 'pending',
            'icon' => 'ri-information-line',
        ],
    };

    $orderStatus = match ($order->status) {
        \App\Models\Order::STATUS_PENDING => [
            'label' => 'Pending',
            'class' => 'pending',
        ],

        \App\Models\Order::STATUS_PAID => [
            'label' => 'Paid',
            'class' => 'paid',
        ],

        \App\Models\Order::STATUS_PROCESSING => [
            'label' => 'Processing',
            'class' => 'processing',
        ],

        \App\Models\Order::STATUS_COMPLETED => [
            'label' => 'Completed',
            'class' => 'completed',
        ],

        \App\Models\Order::STATUS_CANCELLED => [
            'label' => 'Cancelled',
            'class' => 'cancelled',
        ],

        \App\Models\Order::STATUS_FAILED => [
            'label' => 'Failed',
            'class' => 'failed',
        ],

        default => [
            'label' => ucfirst($order->status),
            'class' => 'pending',
        ],
    };

    $customerName = trim(
        ($order->first_name ?? '')
        . ' '
        . ($order->last_name ?? '')
    );

    $customerInitials = collect(
        preg_split('/\s+/', $customerName)
    )
        ->filter()
        ->map(
            fn ($name) => mb_strtoupper(
                mb_substr($name, 0, 1)
            )
        )
        ->take(2)
        ->implode('');

    $customerInitials = $customerInitials !== ''
        ? $customerInitials
        : 'CU';

    $currency = strtoupper((string) $order->currency);

    $currencySymbol = match ($currency) {
        'EUR' => '€',
        'GBP' => '£',
        'CAD' => 'CA$',
        'AUD' => 'A$',
        default => '$',
    };
@endphp

@section('content')

    <div class="shipment-details-page">

        {{-- =========================================================
            HEADER
        ========================================================== --}}

        <div class="shipment-details-page__header">

            <div class="shipment-details-page__breadcrumb">

                <a
                    href="{{ route('ecommerce-shipments') }}"
                    class="shipment-details-page__breadcrumb-link"
                >
                    <i class="ri-truck-line"></i>
                    <span>Shipments</span>
                </a>

                <i class="ri-arrow-right-s-line"></i>

                <span>Shipment Details</span>

            </div>


            <div class="shipment-details-page__header-main">

                <div class="shipment-details-page__title-area">

                    <div class="shipment-details-page__title-icon">
                        <i class="ri-truck-line"></i>
                    </div>

                    <div>

                        <h1 class="shipment-details-page__title">
                            Shipment Details
                        </h1>

                        <p class="shipment-details-page__subtitle">

                            Shipment for order

                            <a
                                href="{{ route('admin-order-details', ['order' => $order->id]) }}"
                            >
                                #{{ $order->order_number }}
                            </a>

                        </p>

                    </div>

                </div>


                <div class="shipment-details-page__header-actions">

                    <a
                        href="{{ route('admin-order-details', ['order' => $order->id]) }}"
                        class="shipment-details-page__secondary-btn"
                    >
                        <i class="ri-arrow-left-line"></i>
                        <span>Back to Order</span>
                    </a>

                </div>

            </div>

        </div>


        {{-- =========================================================
            STATUS OVERVIEW
        ========================================================== --}}

        <section class="shipment-details-page__status-overview">

            <div class="shipment-details-page__status-overview-item">

                <span>
                    Order Status
                </span>

                <strong
                    class="shipment-details-page__status shipment-details-page__status--{{ $orderStatus['class'] }}"
                >
                    <i class="ri-file-list-3-line"></i>
                    {{ $orderStatus['label'] }}
                </strong>

            </div>


            <div class="shipment-details-page__status-overview-item">

                <span>
                    Shipment Status
                </span>

                <strong
                    class="shipment-details-page__status shipment-details-page__status--{{ $shipmentStatus['class'] }}"
                >
                    <i class="{{ $shipmentStatus['icon'] }}"></i>
                    {{ $shipmentStatus['label'] }}
                </strong>

            </div>


            <div class="shipment-details-page__status-overview-item">

                <span>
                    Delivery Status
                </span>

                <strong
                    class="shipment-details-page__status shipment-details-page__status--{{ $deliveryStatus['class'] }}"
                >
                    <i class="{{ $deliveryStatus['icon'] }}"></i>
                    {{ $deliveryStatus['label'] }}
                </strong>

            </div>


            <div class="shipment-details-page__status-overview-item">

                <span>
                    Payment
                </span>

                <strong class="shipment-details-page__status shipment-details-page__status--delivered">

                    <i class="ri-checkbox-circle-line"></i>

                    {{ ucfirst($order->payment_status) }}

                </strong>

            </div>

        </section>


        {{-- =========================================================
            MAIN GRID
        ========================================================== --}}

        <div class="shipment-details-page__grid">

            {{-- =====================================================
                LEFT
            ====================================================== --}}

            <div class="shipment-details-page__main">


                {{-- =================================================
                    SHIPMENT INFORMATION
                ================================================== --}}

                <section class="shipment-details-page__card">

                    <div class="shipment-details-page__card-header">

                        <div class="shipment-details-page__section-icon">
                            <i class="ri-truck-line"></i>
                        </div>

                        <div>

                            <h2 class="shipment-details-page__card-title">
                                Shipment Information
                            </h2>

                            <p class="shipment-details-page__card-subtitle">
                                Current shipment and tracking information.
                            </p>

                        </div>

                    </div>


                    <div class="shipment-details-page__card-body">

                        <div class="shipment-details-page__info-grid">

                            <div class="shipment-details-page__info-item">

                                <span class="shipment-details-page__info-label">
                                    Carrier
                                </span>

                                <strong class="shipment-details-page__info-value">
                                    {{ $shipment->carrier ?: 'Not specified' }}
                                </strong>

                            </div>


                            <div class="shipment-details-page__info-item">

                                <span class="shipment-details-page__info-label">
                                    Tracking Number
                                </span>

                                <strong class="shipment-details-page__info-value">
                                    {{ $shipment->tracking_number ?: 'Not specified' }}
                                </strong>

                            </div>


                            <div class="shipment-details-page__info-item">

                                <span class="shipment-details-page__info-label">
                                    Shipment Status
                                </span>

                                <span
                                    class="shipment-details-page__status shipment-details-page__status--{{ $shipmentStatus['class'] }}"
                                >
                                    <i class="{{ $shipmentStatus['icon'] }}"></i>
                                    {{ $shipmentStatus['label'] }}
                                </span>

                            </div>


                            <div class="shipment-details-page__info-item">

                                <span class="shipment-details-page__info-label">
                                    Delivery Status
                                </span>

                                <span
                                    class="shipment-details-page__status shipment-details-page__status--{{ $deliveryStatus['class'] }}"
                                >
                                    <i class="{{ $deliveryStatus['icon'] }}"></i>
                                    {{ $deliveryStatus['label'] }}
                                </span>

                            </div>


                            <div class="shipment-details-page__info-item">

                                <span class="shipment-details-page__info-label">
                                    Created
                                </span>

                                <strong class="shipment-details-page__info-value">
                                    {{ $shipment->created_at?->format('M d, Y h:i A') ?? '—' }}
                                </strong>

                            </div>


                            <div class="shipment-details-page__info-item">

                                <span class="shipment-details-page__info-label">
                                    Last Updated
                                </span>

                                <strong class="shipment-details-page__info-value">
                                    {{ $shipment->updated_at?->format('M d, Y h:i A') ?? '—' }}
                                </strong>

                            </div>


                            @if ($shipment->shipped_at)

                                <div class="shipment-details-page__info-item">

                                    <span class="shipment-details-page__info-label">
                                        Shipped At
                                    </span>

                                    <strong class="shipment-details-page__info-value">
                                        {{ $shipment->shipped_at->format('M d, Y h:i A') }}
                                    </strong>

                                </div>

                            @endif


                            @if ($shipment->delivered_at)

                                <div class="shipment-details-page__info-item">

                                    <span class="shipment-details-page__info-label">
                                        Delivered At
                                    </span>

                                    <strong class="shipment-details-page__info-value">
                                        {{ $shipment->delivered_at->format('M d, Y h:i A') }}
                                    </strong>

                                </div>

                            @endif

                        </div>

                    </div>

                </section>


                {{-- =================================================
                    UPDATE SHIPMENT
                ================================================== --}}

                <section class="shipment-details-page__card shipment-details-page__update-card">

                    <div class="shipment-details-page__card-header">

                        <div class="shipment-details-page__section-icon shipment-details-page__section-icon--update">
                            <i class="ri-refresh-line"></i>
                        </div>

                        <div>

                            <h2 class="shipment-details-page__card-title">
                                Update Shipment
                            </h2>

                            <p class="shipment-details-page__card-subtitle">
                                Update shipment and delivery status. The related order status will also be synchronized automatically.
                            </p>

                        </div>

                    </div>


                    <form
                        action="{{ route('ecommerce-shipments.update-status', ['shipment' => $shipment->id]) }}"
                        method="POST"
                        class="shipment-details-page__status-form"
                        data-status-form
                    >

                        @csrf

                        @method('PATCH')


                        <div class="shipment-details-page__form-grid">

                            {{-- Shipment Status --}}

                            <div class="shipment-details-page__form-group">

                                <label
                                    for="shipment-status"
                                    class="shipment-details-page__form-label"
                                >
                                    Shipment Status
                                    <span>*</span>
                                </label>

                                <div class="shipment-details-page__select">

                                    <select
                                        id="shipment-status"
                                        name="status"
                                        required
                                        data-status-select
                                    >

                                        <option
                                            value="{{ Shipment::STATUS_PENDING }}"
                                            @selected($shipment->status === Shipment::STATUS_PENDING)
                                        >
                                            Pending
                                        </option>

                                        <option
                                            value="{{ Shipment::STATUS_PROCESSING }}"
                                            @selected($shipment->status === Shipment::STATUS_PROCESSING)
                                        >
                                            Processing
                                        </option>

                                        <option
                                            value="{{ Shipment::STATUS_SHIPPED }}"
                                            @selected($shipment->status === Shipment::STATUS_SHIPPED)
                                        >
                                            Shipped
                                        </option>

                                        <option
                                            value="{{ Shipment::STATUS_CANCELLED }}"
                                            @selected($shipment->status === Shipment::STATUS_CANCELLED)
                                        >
                                            Cancelled
                                        </option>

                                    </select>

                                    <i class="ri-arrow-down-s-line"></i>

                                </div>

                            </div>


                            {{-- Delivery Status --}}

                            <div class="shipment-details-page__form-group">

                                <label
                                    for="delivery-status"
                                    class="shipment-details-page__form-label"
                                >
                                    Delivery Status
                                    <span>*</span>
                                </label>

                                <div class="shipment-details-page__select">

                                    <select
                                        id="delivery-status"
                                        name="delivery_status"
                                        required
                                        data-delivery-select
                                    >

                                        <option
                                            value="{{ Shipment::DELIVERY_STATUS_PENDING }}"
                                            @selected($shipment->delivery_status === Shipment::DELIVERY_STATUS_PENDING)
                                        >
                                            Pending
                                        </option>

                                        <option
                                            value="{{ Shipment::DELIVERY_STATUS_IN_TRANSIT }}"
                                            @selected($shipment->delivery_status === Shipment::DELIVERY_STATUS_IN_TRANSIT)
                                        >
                                            In Transit
                                        </option>

                                        <option
                                            value="{{ Shipment::DELIVERY_STATUS_OUT_FOR_DELIVERY }}"
                                            @selected($shipment->delivery_status === Shipment::DELIVERY_STATUS_OUT_FOR_DELIVERY)
                                        >
                                            Out for Delivery
                                        </option>

                                        <option
                                            value="{{ Shipment::DELIVERY_STATUS_DELIVERED }}"
                                            @selected($shipment->delivery_status === Shipment::DELIVERY_STATUS_DELIVERED)
                                        >
                                            Delivered
                                        </option>

                                        <option
                                            value="{{ Shipment::DELIVERY_STATUS_FAILED }}"
                                            @selected($shipment->delivery_status === Shipment::DELIVERY_STATUS_FAILED)
                                        >
                                            Failed
                                        </option>

                                    </select>

                                    <i class="ri-arrow-down-s-line"></i>

                                </div>

                            </div>

                        </div>


                        {{-- Status synchronization notice --}}

                        <div
                            class="shipment-details-page__status-preview"
                            data-status-preview
                        >

                            <div class="shipment-details-page__preview-icon">

                                <i class="ri-information-line"></i>

                            </div>

                            <div>

                                <strong data-preview-title>
                                    Shipment status update
                                </strong>

                                <span data-preview-text>
                                    Changes will be saved to this shipment.
                                </span>

                            </div>

                        </div>


                        <div class="shipment-details-page__form-actions">

                            <a
                                href="{{ route('ecommerce-shipments.show', ['shipment' => $shipment->id]) }}"
                                class="shipment-details-page__cancel-btn"
                            >
                                Cancel
                            </a>


                            <button
                                type="submit"
                                class="shipment-details-page__save-btn"
                                data-submit-btn
                                disabled
                            >

                                <i class="ri-save-line"></i>

                                <span>
                                    Save Changes
                                </span>

                            </button>

                        </div>

                    </form>

                </section>


                {{-- =================================================
                    NOTES
                ================================================== --}}

                @if (filled($shipment->notes))

                    <section class="shipment-details-page__card">

                        <div class="shipment-details-page__card-header">

                            <div class="shipment-details-page__section-icon">
                                <i class="ri-sticky-note-line"></i>
                            </div>

                            <div>

                                <h2 class="shipment-details-page__card-title">
                                    Shipment Notes
                                </h2>

                                <p class="shipment-details-page__card-subtitle">
                                    Internal shipment notes.
                                </p>

                            </div>

                        </div>


                        <div class="shipment-details-page__notes">
                            {{ $shipment->notes }}
                        </div>

                    </section>

                @endif


                {{-- =================================================
                    ORDER ITEMS
                ================================================== --}}

                <section class="shipment-details-page__card">

                    <div class="shipment-details-page__card-header">

                        <div class="shipment-details-page__section-icon">
                            <i class="ri-shopping-bag-3-line"></i>
                        </div>

                        <div>

                            <h2 class="shipment-details-page__card-title">
                                Order Items
                            </h2>

                            <p class="shipment-details-page__card-subtitle">
                                Items included in this shipment.
                            </p>

                        </div>

                    </div>


                    <div class="shipment-details-page__items">

                        @forelse ($order->items as $item)

                            @php
                                $itemImage = $item->image
                                    ?: $item->product?->thumbnail
                                    ?: $item->product?->image;
                            @endphp

                            <div class="shipment-details-page__item">

                                <div class="shipment-details-page__item-image">

                                    @if ($itemImage)

                                        <img
                                            src="{{ asset($itemImage) }}"
                                            alt="{{ $item->product_name }}"
                                        >

                                    @else

                                        <i class="ri-image-line"></i>

                                    @endif

                                </div>


                                <div class="shipment-details-page__item-info">

                                    @if ($item->product)

                                        <a
                                            href="{{ route('shop.details', ['product' => $item->product->slug]) }}"
                                            class="shipment-details-page__item-name"
                                        >
                                            {{ $item->product_name }}
                                        </a>

                                    @else

                                        <strong class="shipment-details-page__item-name">
                                            {{ $item->product_name }}
                                        </strong>

                                    @endif


                                    @if ($item->sku)

                                        <span class="shipment-details-page__item-sku">
                                            SKU: {{ $item->sku }}
                                        </span>

                                    @endif


                                    <div class="shipment-details-page__item-meta">

                                        <span>
                                            Qty: {{ $item->quantity }}
                                        </span>

                                        @if ($item->variant)

                                            @foreach ($item->variant->values as $value)

                                                <span>
                                                    {{ $value->attribute?->name }}:
                                                    {{ $value->value }}
                                                </span>

                                            @endforeach

                                        @endif

                                    </div>

                                </div>


                                <strong class="shipment-details-page__item-price">

                                    {{ $currencySymbol }}{{ number_format((float) $item->line_total, 2) }}

                                </strong>

                            </div>

                        @empty

                            <div class="shipment-details-page__items-empty">

                                <i class="ri-shopping-bag-line"></i>

                                <span>
                                    No order items found.
                                </span>

                            </div>

                        @endforelse

                    </div>

                </section>

            </div>


            {{-- =====================================================
                SIDEBAR
            ====================================================== --}}

            <aside class="shipment-details-page__sidebar">


                {{-- =================================================
                    ORDER SUMMARY
                ================================================== --}}

                <section class="shipment-details-page__card">

                    <div class="shipment-details-page__card-header">

                        <div class="shipment-details-page__section-icon">
                            <i class="ri-file-list-3-line"></i>
                        </div>

                        <div>

                            <h2 class="shipment-details-page__card-title">
                                Order Summary
                            </h2>

                            <p class="shipment-details-page__card-subtitle">
                                Related order information.
                            </p>

                        </div>

                    </div>


                    <div class="shipment-details-page__summary">

                        <div class="shipment-details-page__summary-row">

                            <span>
                                Order Number
                            </span>

                            <a
                                href="{{ route('admin-order-details', ['order' => $order->id]) }}"
                            >
                                #{{ $order->order_number }}
                            </a>

                        </div>


                        <div class="shipment-details-page__summary-row">

                            <span>
                                Order Status
                            </span>

                            <strong>
                                {{ $orderStatus['label'] }}
                            </strong>

                        </div>


                        <div class="shipment-details-page__summary-row">

                            <span>
                                Items
                            </span>

                            <strong>
                                {{ $order->items->sum('quantity') }}
                            </strong>

                        </div>


                        <div class="shipment-details-page__summary-row">

                            <span>
                                Subtotal
                            </span>

                            <strong>
                                {{ $currencySymbol }}{{ number_format((float) $order->subtotal, 2) }}
                            </strong>

                        </div>


                        <div class="shipment-details-page__summary-row">

                            <span>
                                Shipping
                            </span>

                            <strong>
                                {{ $currencySymbol }}{{ number_format((float) $order->shipping, 2) }}
                            </strong>

                        </div>


                        <div class="shipment-details-page__summary-divider"></div>


                        <div class="shipment-details-page__summary-total">

                            <span>
                                Total
                            </span>

                            <strong>
                                {{ $currencySymbol }}{{ number_format((float) $order->total, 2) }}
                            </strong>

                        </div>

                    </div>

                </section>


                {{-- =================================================
                    CUSTOMER
                ================================================== --}}

                <section class="shipment-details-page__card">

                    <div class="shipment-details-page__card-header">

                        <div class="shipment-details-page__section-icon">
                            <i class="ri-user-line"></i>
                        </div>

                        <div>

                            <h2 class="shipment-details-page__card-title">
                                Customer
                            </h2>

                            <p class="shipment-details-page__card-subtitle">
                                Shipping recipient.
                            </p>

                        </div>

                    </div>


                    <div class="shipment-details-page__customer">

                        <div class="shipment-details-page__avatar">
                            {{ $customerInitials }}
                        </div>


                        <div class="shipment-details-page__customer-info">

                            <strong>
                                {{ $customerName ?: 'Customer' }}
                            </strong>

                            @if ($order->email)

                                <span>
                                    <i class="ri-mail-line"></i>
                                    {{ $order->email }}
                                </span>

                            @endif


                            @if ($order->phone)

                                <span>
                                    <i class="ri-phone-line"></i>
                                    {{ $order->phone }}
                                </span>

                            @endif

                        </div>

                    </div>

                </section>


                {{-- =================================================
                    SHIPPING ADDRESS
                ================================================== --}}

                <section class="shipment-details-page__card">

                    <div class="shipment-details-page__card-header">

                        <div class="shipment-details-page__section-icon">
                            <i class="ri-map-pin-line"></i>
                        </div>

                        <div>

                            <h2 class="shipment-details-page__card-title">
                                Shipping Address
                            </h2>

                            <p class="shipment-details-page__card-subtitle">
                                Delivery destination.
                            </p>

                        </div>

                    </div>


                    <div class="shipment-details-page__address">

                        @if ($order->address)
                            <div>{{ $order->address }}</div>
                        @endif

                        @if ($order->apartment)
                            <div>{{ $order->apartment }}</div>
                        @endif

                        <div>

                            {{ $order->city }}

                            @if ($order->state)
                                , {{ $order->state }}
                            @endif

                        </div>

                        @if ($order->postal_code)
                            <div>{{ $order->postal_code }}</div>
                        @endif

                        @if ($order->country)
                            <div>{{ $order->country }}</div>
                        @endif

                    </div>

                </section>

            </aside>

        </div>

    </div>

@endsection


@push('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const page = document.querySelector(
                '.shipment-details-page'
            );

            if (!page) {
                return;
            }


            const form = page.querySelector(
                '[data-status-form]'
            );

            const statusSelect = page.querySelector(
                '[data-status-select]'
            );

            const deliverySelect = page.querySelector(
                '[data-delivery-select]'
            );

            const submitButton = page.querySelector(
                '[data-submit-btn]'
            );

            const preview = page.querySelector(
                '[data-status-preview]'
            );

            const previewTitle = page.querySelector(
                '[data-preview-title]'
            );

            const previewText = page.querySelector(
                '[data-preview-text]'
            );


            if (
                !form
                || !statusSelect
                || !deliverySelect
            ) {
                return;
            }


            const originalStatus =
                statusSelect.value;

            const originalDeliveryStatus =
                deliverySelect.value;


            const statusLabels = {
                pending: 'Pending',
                processing: 'Processing',
                shipped: 'Shipped',
                cancelled: 'Cancelled'
            };


            const deliveryLabels = {
                pending: 'Pending',
                in_transit: 'In Transit',
                out_for_delivery: 'Out for Delivery',
                delivered: 'Delivered',
                failed: 'Failed'
            };


            function getOrderStatusPreview(
                status,
                deliveryStatus
            ) {

                if (status === 'cancelled') {
                    return 'Cancelled';
                }

                if (deliveryStatus === 'delivered') {
                    return 'Completed';
                }

                if (
                    status === 'processing'
                    || status === 'shipped'
                    || deliveryStatus === 'in_transit'
                    || deliveryStatus === 'out_for_delivery'
                    || deliveryStatus === 'failed'
                ) {
                    return 'Processing';
                }

                if (
                    status === 'pending'
                    && deliveryStatus === 'pending'
                ) {
                    return 'Paid';
                }

                return 'Processing';
            }


            function updatePreview() {

                const statusChanged =
                    statusSelect.value !== originalStatus;

                const deliveryChanged =
                    deliverySelect.value
                    !== originalDeliveryStatus;


                if (
                    !statusChanged
                    && !deliveryChanged
                ) {

                    if (preview) {
                        preview.classList.remove(
                            'is-active'
                        );
                    }

                    if (submitButton) {
                        submitButton.disabled = true;
                    }

                    return;
                }


                if (preview) {
                    preview.classList.add(
                        'is-active'
                    );
                }


                if (submitButton) {
                    submitButton.disabled = false;
                }


                const statusText =
                    statusLabels[statusSelect.value]
                    || statusSelect.value;


                const deliveryText =
                    deliveryLabels[deliverySelect.value]
                    || deliverySelect.value;


                const nextOrderStatus =
                    getOrderStatusPreview(
                        statusSelect.value,
                        deliverySelect.value
                    );


                if (previewTitle) {

                    previewTitle.textContent =
                        'Order status will also be synchronized';

                }


                if (previewText) {

                    previewText.textContent =
                        `Shipment: ${statusText} • Delivery: ${deliveryText} • Order: ${nextOrderStatus}`;

                }

            }


            statusSelect.addEventListener(
                'change',
                updatePreview
            );


            deliverySelect.addEventListener(
                'change',
                updatePreview
            );


            form.addEventListener(
                'submit',
                function (event) {

                    const statusChanged =
                        statusSelect.value !== originalStatus;

                    const deliveryChanged =
                        deliverySelect.value
                        !== originalDeliveryStatus;


                    if (
                        !statusChanged
                        && !deliveryChanged
                    ) {

                        event.preventDefault();

                        return;
                    }


                    if (
                        window.Swal
                        && typeof window.Swal.fire
                        === 'function'
                    ) {

                        event.preventDefault();


                        const nextOrderStatus =
                            getOrderStatusPreview(
                                statusSelect.value,
                                deliverySelect.value
                            );


                        Swal.fire({

                            icon: 'question',

                            title: 'Update shipment status?',

                            html:
                                'Shipment and delivery status will be updated.<br>' +
                                '<strong>Related order status will become ' +
                                nextOrderStatus +
                                '.</strong>',

                            showCancelButton: true,

                            confirmButtonText:
                                'Yes, update',

                            cancelButtonText:
                                'Cancel',

                            reverseButtons: true

                        }).then(function (result) {

                            if (
                                result.isConfirmed
                            ) {

                                if (submitButton) {

                                    submitButton.disabled =
                                        true;

                                    submitButton.innerHTML =
                                        '<i class="ri-loader-4-line"></i>' +
                                        '<span>Updating...</span>';

                                }


                                form.submit();

                            }

                        });

                        return;
                    }


                    if (submitButton) {

                        submitButton.disabled =
                            true;

                        submitButton.innerHTML =
                            '<i class="ri-loader-4-line"></i>' +
                            '<span>Updating...</span>';

                    }

                }
            );


            updatePreview();

        });
    </script>

@endpush
