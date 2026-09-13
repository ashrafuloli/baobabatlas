@extends('backend.layouts.backend')

@section('title', 'Create Shipment')

@section('content')
    <div class="shipment-create-page">
        <div class="shipment-create-page__container">

            {{-- Page Header --}}
            <div class="shipment-create-page__header">
                <div class="shipment-create-page__header-content">
                    <div class="shipment-create-page__breadcrumb">
                        <a href="{{ route('ecommerce-shipments') }}">
                            <i class="ri-truck-line"></i>
                            Shipments
                        </a>

                        <i class="ri-arrow-right-s-line"></i>

                        <span>Create Shipment</span>
                    </div>

                    <div class="shipment-create-page__title-row">
                        <div>
                            <h1 class="shipment-create-page__title">
                                Create Shipment
                            </h1>

                            <p class="shipment-create-page__subtitle">
                                Create a shipment for order
                                <strong>#{{ $order->order_number }}</strong>
                            </p>
                        </div>

                        <a
                            href="{{ route('admin-order-details', ['order' => $order->id]) }}"
                            class="shipment-create-page__back-btn"
                        >
                            <i class="ri-arrow-left-line"></i>
                            <span>Back to Order</span>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Main Content --}}
            <form
                action="{{ route('ecommerce-shipments.store') }}"
                method="POST"
                class="shipment-create-page__form"
                data-shipment-form
            >
                @csrf

                <input
                    type="hidden"
                    name="order_id"
                    value="{{ $order->id }}"
                >

                <div class="shipment-create-page__grid">

                    {{-- Left Column --}}
                    <div class="shipment-create-page__main">

                        {{-- Shipment Information --}}
                        <div class="shipment-create-page__card">
                            <div class="shipment-create-page__card-header">
                                <div class="shipment-create-page__card-icon">
                                    <i class="ri-truck-line"></i>
                                </div>

                                <div>
                                    <h2 class="shipment-create-page__card-title">
                                        Shipment Information
                                    </h2>

                                    <p class="shipment-create-page__card-description">
                                        Enter the carrier and tracking information.
                                    </p>
                                </div>
                            </div>

                            <div class="shipment-create-page__card-body">

                                <div class="shipment-create-page__field-grid">

                                    {{-- Carrier --}}
                                    <div class="shipment-create-page__field">
                                        <label
                                            for="carrier"
                                            class="shipment-create-page__label"
                                        >
                                            Carrier
                                            <span>*</span>
                                        </label>

                                        <div class="shipment-create-page__input-wrap">
                                            <i class="ri-roadster-line"></i>

                                            <input
                                                type="text"
                                                id="carrier"
                                                name="carrier"
                                                value="{{ old('carrier') }}"
                                                class="shipment-create-page__input"
                                                placeholder="e.g. DHL, FedEx, UPS"
                                                maxlength="100"
                                                required
                                            >
                                        </div>

                                        @error('carrier')
                                        <span class="shipment-create-page__error">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                    </div>

                                    {{-- Tracking Number --}}
                                    <div class="shipment-create-page__field">
                                        <label
                                            for="tracking_number"
                                            class="shipment-create-page__label"
                                        >
                                            Tracking Number
                                        </label>

                                        <div class="shipment-create-page__input-wrap">
                                            <i class="ri-barcode-line"></i>

                                            <input
                                                type="text"
                                                id="tracking_number"
                                                name="tracking_number"
                                                value="{{ old('tracking_number') }}"
                                                class="shipment-create-page__input"
                                                placeholder="Enter tracking number"
                                                maxlength="255"
                                            >
                                        </div>

                                        @error('tracking_number')
                                        <span class="shipment-create-page__error">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                    </div>

                                </div>

                                {{-- Shipment Status --}}
                                <div class="shipment-create-page__field">
                                    <label
                                        for="status"
                                        class="shipment-create-page__label"
                                    >
                                        Shipment Status
                                        <span>*</span>
                                    </label>

                                    <div class="shipment-create-page__select-wrap">
                                        <i class="ri-box-3-line"></i>

                                        <select
                                            id="status"
                                            name="status"
                                            class="shipment-create-page__select"
                                            required
                                        >
                                            <option
                                                value="{{ \App\Models\Shipment::STATUS_PENDING }}"
                                                @selected(old('status', \App\Models\Shipment::STATUS_PENDING) === \App\Models\Shipment::STATUS_PENDING)
                                            >
                                                Pending
                                            </option>

                                            <option
                                                value="{{ \App\Models\Shipment::STATUS_PROCESSING }}"
                                                @selected(old('status') === \App\Models\Shipment::STATUS_PROCESSING)
                                            >
                                                Processing
                                            </option>

                                            <option
                                                value="{{ \App\Models\Shipment::STATUS_SHIPPED }}"
                                                @selected(old('status') === \App\Models\Shipment::STATUS_SHIPPED)
                                            >
                                                Shipped
                                            </option>
                                        </select>

                                        <i class="ri-arrow-down-s-line shipment-create-page__select-arrow"></i>
                                    </div>

                                    @error('status')
                                    <span class="shipment-create-page__error">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>

                                {{-- Delivery Status --}}
                                <div class="shipment-create-page__field">
                                    <label
                                        for="delivery_status"
                                        class="shipment-create-page__label"
                                    >
                                        Delivery Status
                                        <span>*</span>
                                    </label>

                                    <div class="shipment-create-page__select-wrap">
                                        <i class="ri-map-pin-time-line"></i>

                                        <select
                                            id="delivery_status"
                                            name="delivery_status"
                                            class="shipment-create-page__select"
                                            required
                                        >
                                            <option
                                                value="{{ \App\Models\Shipment::DELIVERY_STATUS_PENDING }}"
                                                @selected(old('delivery_status', \App\Models\Shipment::DELIVERY_STATUS_PENDING) === \App\Models\Shipment::DELIVERY_STATUS_PENDING)
                                            >
                                                Pending
                                            </option>

                                            <option
                                                value="{{ \App\Models\Shipment::DELIVERY_STATUS_IN_TRANSIT }}"
                                                @selected(old('delivery_status') === \App\Models\Shipment::DELIVERY_STATUS_IN_TRANSIT)
                                            >
                                                In Transit
                                            </option>

                                            <option
                                                value="{{ \App\Models\Shipment::DELIVERY_STATUS_OUT_FOR_DELIVERY }}"
                                                @selected(old('delivery_status') === \App\Models\Shipment::DELIVERY_STATUS_OUT_FOR_DELIVERY)
                                            >
                                                Out for Delivery
                                            </option>

                                            <option
                                                value="{{ \App\Models\Shipment::DELIVERY_STATUS_DELIVERED }}"
                                                @selected(old('delivery_status') === \App\Models\Shipment::DELIVERY_STATUS_DELIVERED)
                                            >
                                                Delivered
                                            </option>

                                            <option
                                                value="{{ \App\Models\Shipment::DELIVERY_STATUS_FAILED }}"
                                                @selected(old('delivery_status') === \App\Models\Shipment::DELIVERY_STATUS_FAILED)
                                            >
                                                Failed
                                            </option>
                                        </select>

                                        <i class="ri-arrow-down-s-line shipment-create-page__select-arrow"></i>
                                    </div>

                                    @error('delivery_status')
                                    <span class="shipment-create-page__error">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>

                                {{-- Notes --}}
                                <div class="shipment-create-page__field">
                                    <label
                                        for="notes"
                                        class="shipment-create-page__label"
                                    >
                                        Notes
                                    </label>

                                    <div class="shipment-create-page__textarea-wrap">
                                        <i class="ri-sticky-note-line"></i>

                                        <textarea
                                            id="notes"
                                            name="notes"
                                            class="shipment-create-page__textarea"
                                            rows="5"
                                            maxlength="5000"
                                            placeholder="Add any internal shipment notes..."
                                        >{{ old('notes') }}</textarea>
                                    </div>

                                    <div class="shipment-create-page__field-meta">
                                    <span>
                                        Optional internal notes
                                    </span>

                                        <span data-notes-count>
                                        0 / 5000
                                    </span>
                                    </div>

                                    @error('notes')
                                    <span class="shipment-create-page__error">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>

                            </div>
                        </div>

                        {{-- Order Items --}}
                        <div class="shipment-create-page__card">
                            <div class="shipment-create-page__card-header">
                                <div class="shipment-create-page__card-icon">
                                    <i class="ri-shopping-bag-3-line"></i>
                                </div>

                                <div>
                                    <h2 class="shipment-create-page__card-title">
                                        Order Items
                                    </h2>

                                    <p class="shipment-create-page__card-description">
                                        Items included in this shipment.
                                    </p>
                                </div>
                            </div>

                            <div class="shipment-create-page__items">

                                @forelse($order->items as $item)
                                    <div class="shipment-create-page__item">

                                        <div class="shipment-create-page__item-image">
                                            @if($item->image)
                                                <img
                                                    src="{{ asset($item->image) }}"
                                                    alt="{{ $item->product_name }}"
                                                >
                                            @else
                                                <div class="shipment-create-page__item-placeholder">
                                                    <i class="ri-image-line"></i>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="shipment-create-page__item-content">
                                            <h3 class="shipment-create-page__item-title">
                                                {{ $item->product_name }}
                                            </h3>

                                            @if($item->sku)
                                                <span class="shipment-create-page__item-sku">
                                                SKU: {{ $item->sku }}
                                            </span>
                                            @endif

                                            <div class="shipment-create-page__item-meta">
                                            <span>
                                                Qty: {{ $item->quantity }}
                                            </span>

                                                @if($item->variant)
                                                    @foreach($item->variant->values as $value)
                                                        <span>
                                                        {{ $value->attribute->name ?? 'Option' }}:
                                                        {{ $value->value }}
                                                    </span>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>

                                        <div class="shipment-create-page__item-price">
                                            ${{ number_format((float) $item->line_total, 2) }}
                                        </div>

                                    </div>
                                @empty
                                    <div class="shipment-create-page__empty">
                                        <i class="ri-shopping-bag-line"></i>
                                        <span>No items found for this order.</span>
                                    </div>
                                @endforelse

                            </div>
                        </div>

                    </div>

                    {{-- Right Column --}}
                    <aside class="shipment-create-page__sidebar">

                        {{-- Order Summary --}}
                        <div class="shipment-create-page__card">
                            <div class="shipment-create-page__card-header">
                                <div class="shipment-create-page__card-icon">
                                    <i class="ri-file-list-3-line"></i>
                                </div>

                                <div>
                                    <h2 class="shipment-create-page__card-title">
                                        Order Summary
                                    </h2>

                                    <p class="shipment-create-page__card-description">
                                        Order information.
                                    </p>
                                </div>
                            </div>

                            <div class="shipment-create-page__summary">

                                <div class="shipment-create-page__summary-row">
                                    <span>Order Number</span>

                                    <strong>
                                        #{{ $order->order_number }}
                                    </strong>
                                </div>

                                <div class="shipment-create-page__summary-row">
                                    <span>Items</span>

                                    <strong>
                                        {{ $order->items->sum('quantity') }}
                                    </strong>
                                </div>

                                <div class="shipment-create-page__summary-row">
                                    <span>Subtotal</span>

                                    <strong>
                                        ${{ number_format((float) $order->subtotal, 2) }}
                                    </strong>
                                </div>

                                <div class="shipment-create-page__summary-row">
                                    <span>Shipping</span>

                                    <strong>
                                        ${{ number_format((float) $order->shipping, 2) }}
                                    </strong>
                                </div>

                                <div class="shipment-create-page__summary-row shipment-create-page__summary-row--total">
                                    <span>Total</span>

                                    <strong>
                                        ${{ number_format((float) $order->total, 2) }}
                                    </strong>
                                </div>

                                <div class="shipment-create-page__payment-status">
                                <span class="shipment-create-page__payment-status-icon">
                                    <i class="ri-checkbox-circle-line"></i>
                                </span>

                                    <div>
                                        <strong>Payment Confirmed</strong>
                                        <span>
                                        This order is eligible for shipment.
                                    </span>
                                    </div>
                                </div>

                            </div>
                        </div>

                        {{-- Customer Information --}}
                        <div class="shipment-create-page__card">
                            <div class="shipment-create-page__card-header">
                                <div class="shipment-create-page__card-icon">
                                    <i class="ri-user-3-line"></i>
                                </div>

                                <div>
                                    <h2 class="shipment-create-page__card-title">
                                        Customer
                                    </h2>

                                    <p class="shipment-create-page__card-description">
                                        Shipping recipient.
                                    </p>
                                </div>
                            </div>

                            <div class="shipment-create-page__customer">

                                <div class="shipment-create-page__customer-avatar">
                                    {{ strtoupper(substr($order->first_name, 0, 1)) }}
                                    {{ strtoupper(substr($order->last_name, 0, 1)) }}
                                </div>

                                <div class="shipment-create-page__customer-info">
                                    <strong>
                                        {{ $order->first_name }}
                                        {{ $order->last_name }}
                                    </strong>

                                    <span>
                                    <i class="ri-mail-line"></i>
                                    {{ $order->email }}
                                </span>

                                    @if($order->phone)
                                        <span>
                                        <i class="ri-phone-line"></i>
                                        {{ $order->phone }}
                                    </span>
                                    @endif
                                </div>

                            </div>

                            <div class="shipment-create-page__address">

                                <div class="shipment-create-page__address-title">
                                    <i class="ri-map-pin-line"></i>
                                    Shipping Address
                                </div>

                                <p>
                                    {{ $order->address }}

                                    @if($order->apartment)
                                        <br>
                                        {{ $order->apartment }}
                                    @endif

                                    <br>
                                    {{ $order->city }},
                                    {{ $order->state }}
                                    {{ $order->postal_code }}

                                    @if($order->country)
                                        <br>
                                        {{ $order->country }}
                                    @endif
                                </p>

                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="shipment-create-page__actions">

                            <a
                                href="{{ route('admin-order-details', ['order' => $order->id]) }}"
                                class="shipment-create-page__cancel-btn"
                            >
                                Cancel
                            </a>

                            <button
                                type="submit"
                                class="shipment-create-page__submit-btn"
                                data-submit-button
                            >
                                <i class="ri-truck-line"></i>
                                <span>Create Shipment</span>
                            </button>

                        </div>

                    </aside>

                </div>
            </form>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const shipmentPage = document.querySelector(
                ".shipment-create-page"
            );

            if (!shipmentPage) {
                return;
            }

            const form = shipmentPage.querySelector(
                "[data-shipment-form]"
            );

            const submitButton = shipmentPage.querySelector(
                "[data-submit-button]"
            );

            const notes = shipmentPage.querySelector(
                "#notes"
            );

            const notesCount = shipmentPage.querySelector(
                "[data-notes-count]"
            );

            if (notes && notesCount) {
                const updateNotesCount = function () {
                    notesCount.textContent =
                        `${notes.value.length} / 5000`;
                };

                notes.addEventListener(
                    "input",
                    updateNotesCount
                );

                updateNotesCount();
            }

            if (form && submitButton) {
                form.addEventListener("submit", function () {
                    if (!form.checkValidity()) {
                        return;
                    }

                    submitButton.disabled = true;

                    submitButton.classList.add(
                        "is-loading"
                    );

                    submitButton.innerHTML = `
                        <i class="ri-loader-4-line"></i>
                        <span>Creating Shipment...</span>
                    `;
                });
            }
        });
    </script>
@endpush
