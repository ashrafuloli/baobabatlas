@extends('backend.layouts.backend')

@section('title', 'Edit Shipment')

@section('content')

    @php

        /*
        |--------------------------------------------------------------------------
        | Request / Quote Data
        |--------------------------------------------------------------------------
        */

        $quote =
            $smartBuy->latestQuote
            ?? $smartBuy->quote
            ?? null;


        /*
        |--------------------------------------------------------------------------
        | Currency
        |--------------------------------------------------------------------------
        */

        $currency =
            $quote?->currency
            ?? $smartBuy->currency
            ?? 'USD';


        /*
        |--------------------------------------------------------------------------
        | Quote Items
        |--------------------------------------------------------------------------
        */

        $quoteItems =
            $quote?->quoteItems
            ?? collect();


        /*
        |--------------------------------------------------------------------------
        | Product Subtotal
        |--------------------------------------------------------------------------
        */

        $productSubtotal = 0;


        foreach ($quoteItems as $quoteItem) {

            $quantity =
                (float) (
                    $quoteItem->quantity
                    ?? 1
                );


            $unitPrice =
                (float) (
                    $quoteItem->unit_price
                    ?? $quoteItem->price
                    ?? 0
                );


            $itemTotal =
                (float) (
                    $quoteItem->total_price
                    ?? $quoteItem->total_amount
                    ?? $quoteItem->total
                    ?? (
                        $unitPrice
                        *
                        $quantity
                    )
                );


            $productSubtotal +=
                $itemTotal;

        }


        /*
        |--------------------------------------------------------------------------
        | Use Quote Product Total When Available
        |--------------------------------------------------------------------------
        */

        $quotedProductTotal =
            $quote?->product_total
            ?? $quote?->products_total
            ?? $quote?->subtotal
            ?? null;


        if (
            $quotedProductTotal !== null
            &&
            (float) $quotedProductTotal >= 0
        ) {

            $productSubtotal =
                (float) $quotedProductTotal;

        }


        /*
        |--------------------------------------------------------------------------
        | Service Fee
        |--------------------------------------------------------------------------
        */

        $serviceFee =
            (float) (
                $quote?->service_fee
                ?? $smartBuy->service_fee
                ?? 0
            );


        /*
        |--------------------------------------------------------------------------
        | Shipping Cost
        |--------------------------------------------------------------------------
        */

        $shippingCost =
            (float) (
                $shipment->shipping_cost
                ?? $quote?->shipping_fee
                ?? $quote?->shipping_cost
                ?? $smartBuy->shipping_cost
                ?? $smartBuy->shipping_fee
                ?? 0
            );


        /*
        |--------------------------------------------------------------------------
        | Total Amount
        |--------------------------------------------------------------------------
        */

        $quoteTotal =
            $quote?->total_amount
            ?? $quote?->total
            ?? null;


        $orderTotal =
            $quoteTotal !== null
                ? (float) $quoteTotal
                : (
                    $productSubtotal
                    +
                    $serviceFee
                    +
                    $shippingCost
                );


        /*
        |--------------------------------------------------------------------------
        | Product Count
        |--------------------------------------------------------------------------
        */

        $productCount =
            $quoteItems->count() > 0
                ? $quoteItems->count()
                : $smartBuy->items->count();


        /*
        |--------------------------------------------------------------------------
        | Shipment Date Formatting
        |--------------------------------------------------------------------------
        */

        $shippedAt =
            old(
                'shipped_at',
                $shipment->shipped_at
                    ? \Carbon\Carbon::parse(
                        $shipment->shipped_at
                    )->format('Y-m-d\TH:i')
                    : ''
            );


        $estimatedDeliveryAt =
            old(
                'estimated_delivery_at',
                $shipment->estimated_delivery_at
                    ? \Carbon\Carbon::parse(
                        $shipment->estimated_delivery_at
                    )->format('Y-m-d\TH:i')
                    : ''
            );


        $deliveredAt =
            old(
                'delivered_at',
                $shipment->delivered_at
                    ? \Carbon\Carbon::parse(
                        $shipment->delivered_at
                    )->format('Y-m-d\TH:i')
                    : ''
            );

    @endphp


    <div class="shipment-create-page">


        {{-- ============================================================
            PAGE HEADER
        ============================================================ --}}

        <div class="shipment-create-page__header">

            <div class="shipment-create-page__header-left">

                <a
                    href="{{ route('smart-buy.details', $smartBuy->id) }}"
                    class="shipment-create-page__back"
                >

                    <i class="fa-solid fa-arrow-left"></i>

                    <span>
                        Back to Request
                    </span>

                </a>


                <div class="shipment-create-page__title">

                    <div class="shipment-create-page__title-icon">

                        <i class="fa-solid fa-truck-fast"></i>

                    </div>


                    <div>

                        <h1>
                            Edit Shipment
                        </h1>

                        <p>
                            Update and manage shipping information for this Smart Buy request.
                        </p>

                    </div>

                </div>

            </div>


            <div class="shipment-create-page__request-id">

                <span>
                    Smart Buy Request
                </span>

                <strong>

                    {{
                        $smartBuy->request_number
                        ?? 'SB-' . str_pad(
                            $smartBuy->id,
                            6,
                            '0',
                            STR_PAD_LEFT
                        )
                    }}

                </strong>

            </div>

        </div>



        {{-- ============================================================
            REQUEST INFORMATION
        ============================================================ --}}

        <div class="shipment-create-page__request-card">

            <div class="shipment-create-page__section-heading">

                <div>

                    <h2>
                        Request Information
                    </h2>

                    <p>
                        Review the Smart Buy request before updating the shipment.
                    </p>

                </div>

            </div>


            <div class="shipment-create-page__request-grid">


                {{-- Customer --}}

                <div class="shipment-create-page__request-item">

                    <div class="shipment-create-page__request-icon">

                        <i class="fa-solid fa-user"></i>

                    </div>


                    <div>

                        <span>
                            Customer
                        </span>

                        <strong>

                            {{
                                $smartBuy->user?->name
                                ?? (
                                    trim(
                                        ($smartBuy->first_name ?? '')
                                        . ' '
                                        . ($smartBuy->last_name ?? '')
                                    )
                                    ?: 'N/A'
                                )
                            }}

                        </strong>

                    </div>

                </div>



                {{-- Request Status --}}

                <div class="shipment-create-page__request-item">

                    <div class="shipment-create-page__request-icon">

                        <i class="fa-solid fa-circle-check"></i>

                    </div>


                    <div>

                        <span>
                            Request Status
                        </span>

                        <strong>

                            {{
                                ucwords(
                                    str_replace(
                                        '_',
                                        ' ',
                                        $smartBuy->status
                                    )
                                )
                            }}

                        </strong>

                    </div>

                </div>



                {{-- Products --}}

                <div class="shipment-create-page__request-item">

                    <div class="shipment-create-page__request-icon">

                        <i class="fa-solid fa-bag-shopping"></i>

                    </div>


                    <div>

                        <span>
                            Products
                        </span>

                        <strong>

                            {{ $productCount }}

                            Item{{ $productCount !== 1 ? 's' : '' }}

                        </strong>

                    </div>

                </div>



                {{-- Destination --}}

                <div class="shipment-create-page__request-item">

                    <div class="shipment-create-page__request-icon">

                        <i class="fa-solid fa-location-dot"></i>

                    </div>


                    <div>

                        <span>
                            Destination
                        </span>

                        <strong>

                            {{
                                $shipment->country
                                ?? $smartBuy->country
                                ?? 'N/A'
                            }}

                        </strong>

                    </div>

                </div>

            </div>

        </div>



        {{-- ============================================================
            MAIN CONTENT
        ============================================================ --}}

        <div class="shipment-create-page__layout">


            {{-- ========================================================
                LEFT CONTENT
            ========================================================= --}}

            <form
                id="editShipmentForm"
                action="{{ route('smart-buy.shipment.update', $shipment) }}"
                method="POST"
                class="shipment-create-page__form"
            >

                @csrf

                @method('PUT')


                {{-- ====================================================
                    SHIPPING INFORMATION
                ===================================================== --}}

                <div class="shipment-create-page__card">

                    <div class="shipment-create-page__card-header">

                        <div class="shipment-create-page__card-title">

                            <div class="shipment-create-page__card-icon">

                                <i class="fa-solid fa-truck"></i>

                            </div>


                            <div>

                                <h2>
                                    Shipping Information
                                </h2>

                                <p>
                                    Update the carrier and tracking details.
                                </p>

                            </div>

                        </div>

                    </div>


                    <div class="shipment-create-page__card-body">

                        <div class="shipment-create-page__form-grid">


                            {{-- Carrier --}}

                            <div class="shipment-create-page__field">

                                <label for="carrier">
                                    Carrier
                                </label>

                                <input
                                    type="text"
                                    name="carrier"
                                    id="carrier"
                                    value="{{ old('carrier', $shipment->carrier) }}"
                                    placeholder="e.g. DHL, FedEx, UPS"
                                >

                                @error('carrier')

                                <span class="shipment-create-page__error">
                                        {{ $message }}
                                    </span>

                                @enderror

                            </div>



                            {{-- Shipping Method --}}

                            <div class="shipment-create-page__field">

                                <label for="shipping_method">
                                    Shipping Method
                                </label>

                                <input
                                    type="text"
                                    name="shipping_method"
                                    id="shipping_method"
                                    value="{{ old('shipping_method', $shipment->shipping_method) }}"
                                    placeholder="e.g. Express Delivery"
                                >

                                @error('shipping_method')

                                <span class="shipment-create-page__error">
                                        {{ $message }}
                                    </span>

                                @enderror

                            </div>



                            {{-- Tracking Number --}}

                            <div class="shipment-create-page__field">

                                <label for="tracking_number">
                                    Tracking Number
                                </label>

                                <input
                                    type="text"
                                    name="tracking_number"
                                    id="tracking_number"
                                    value="{{ old('tracking_number', $shipment->tracking_number) }}"
                                    placeholder="Enter tracking number"
                                >

                                @error('tracking_number')

                                <span class="shipment-create-page__error">
                                        {{ $message }}
                                    </span>

                                @enderror

                            </div>



                            {{-- Tracking URL --}}

                            <div class="shipment-create-page__field">

                                <label for="tracking_url">
                                    Tracking URL
                                </label>

                                <input
                                    type="url"
                                    name="tracking_url"
                                    id="tracking_url"
                                    value="{{ old('tracking_url', $shipment->tracking_url) }}"
                                    placeholder="https://..."
                                >

                                @error('tracking_url')

                                <span class="shipment-create-page__error">
                                        {{ $message }}
                                    </span>

                                @enderror

                            </div>

                        </div>

                    </div>

                </div>



                {{-- ====================================================
                    SHIPMENT STATUS
                ===================================================== --}}

                <div class="shipment-create-page__card">

                    <div class="shipment-create-page__card-header">

                        <div class="shipment-create-page__card-title">

                            <div class="shipment-create-page__card-icon">

                                <i class="fa-solid fa-arrow-right-arrow-left"></i>

                            </div>


                            <div>

                                <h2>
                                    Shipment Status
                                </h2>

                                <p>
                                    Update the current stage of the shipment.
                                </p>

                            </div>

                        </div>

                    </div>


                    <div class="shipment-create-page__card-body">

                        <div class="shipment-create-page__field">

                            <label for="status">
                                Current Status
                            </label>

                            <select
                                name="status"
                                id="status"
                            >

                                @foreach(\App\Models\SmartBuyShipment::STATUSES as $status)

                                    <option
                                        value="{{ $status }}"
                                        @selected(
                                            old(
                                                'status',
                                                $shipment->status
                                                ?? \App\Models\SmartBuyShipment::STATUS_PENDING
                                            ) === $status
                                        )
                                    >

                                        {{
                                            ucwords(
                                                str_replace(
                                                    '_',
                                                    ' ',
                                                    $status
                                                )
                                            )
                                        }}

                                    </option>

                                @endforeach

                            </select>

                            @error('status')

                            <span class="shipment-create-page__error">
                                    {{ $message }}
                                </span>

                            @enderror

                        </div>

                    </div>

                </div>



                {{-- ====================================================
                    SHIPPING DATES
                ===================================================== --}}

                <div class="shipment-create-page__card">

                    <div class="shipment-create-page__card-header">

                        <div class="shipment-create-page__card-title">

                            <div class="shipment-create-page__card-icon">

                                <i class="fa-solid fa-calendar-days"></i>

                            </div>


                            <div>

                                <h2>
                                    Shipping Dates
                                </h2>

                                <p>
                                    Update important shipment and delivery dates.
                                </p>

                            </div>

                        </div>

                    </div>


                    <div class="shipment-create-page__card-body">

                        <div class="shipment-create-page__form-grid">


                            {{-- Shipped Date --}}

                            <div class="shipment-create-page__field">

                                <label for="shipped_at">
                                    Shipped Date
                                </label>

                                <input
                                    type="datetime-local"
                                    name="shipped_at"
                                    id="shipped_at"
                                    value="{{ $shippedAt }}"
                                >

                                @error('shipped_at')

                                <span class="shipment-create-page__error">
                                        {{ $message }}
                                    </span>

                                @enderror

                            </div>



                            {{-- Estimated Delivery --}}

                            <div class="shipment-create-page__field">

                                <label for="estimated_delivery_at">
                                    Estimated Delivery
                                </label>

                                <input
                                    type="datetime-local"
                                    name="estimated_delivery_at"
                                    id="estimated_delivery_at"
                                    value="{{ $estimatedDeliveryAt }}"
                                >

                                @error('estimated_delivery_at')

                                <span class="shipment-create-page__error">
                                        {{ $message }}
                                    </span>

                                @enderror

                            </div>



                            {{-- Delivered Date --}}

                            <div class="shipment-create-page__field">

                                <label for="delivered_at">
                                    Delivered Date
                                </label>

                                <input
                                    type="datetime-local"
                                    name="delivered_at"
                                    id="delivered_at"
                                    value="{{ $deliveredAt }}"
                                >

                                @error('delivered_at')

                                <span class="shipment-create-page__error">
                                        {{ $message }}
                                    </span>

                                @enderror

                            </div>

                        </div>

                    </div>

                </div>



                {{-- ====================================================
                    DELIVERY INFORMATION
                ===================================================== --}}

                <div class="shipment-create-page__card">

                    <div class="shipment-create-page__card-header">

                        <div class="shipment-create-page__card-title">

                            <div class="shipment-create-page__card-icon">

                                <i class="fa-solid fa-location-dot"></i>

                            </div>


                            <div>

                                <h2>
                                    Delivery Information
                                </h2>

                                <p>
                                    Update where the products will be delivered.
                                </p>

                            </div>

                        </div>

                    </div>


                    <div class="shipment-create-page__card-body">

                        <div class="shipment-create-page__form-grid">


                            {{-- Country --}}

                            <div class="shipment-create-page__field">

                                <label for="country">
                                    Country
                                </label>

                                <input
                                    type="text"
                                    name="country"
                                    id="country"
                                    value="{{ old('country', $shipment->country ?? $smartBuy->country) }}"
                                >

                                @error('country')

                                <span class="shipment-create-page__error">
                                        {{ $message }}
                                    </span>

                                @enderror

                            </div>



                            {{-- City --}}

                            <div class="shipment-create-page__field">

                                <label for="city">
                                    City
                                </label>

                                <input
                                    type="text"
                                    name="city"
                                    id="city"
                                    value="{{ old('city', $shipment->city ?? $smartBuy->city) }}"
                                >

                                @error('city')

                                <span class="shipment-create-page__error">
                                        {{ $message }}
                                    </span>

                                @enderror

                            </div>



                            {{-- Zip Code --}}

                            <div class="shipment-create-page__field">

                                <label for="zip_code">
                                    Zip Code
                                </label>

                                <input
                                    type="text"
                                    name="zip_code"
                                    id="zip_code"
                                    value="{{ old('zip_code', $shipment->zip_code ?? $smartBuy->zip_code) }}"
                                >

                                @error('zip_code')

                                <span class="shipment-create-page__error">
                                        {{ $message }}
                                    </span>

                                @enderror

                            </div>



                            {{-- Delivery Address --}}

                            <div class="shipment-create-page__field shipment-create-page__field--full">

                                <label for="delivery_address">
                                    Delivery Address
                                </label>

                                <textarea
                                    name="delivery_address"
                                    id="delivery_address"
                                    rows="4"
                                >{{ old('delivery_address', $shipment->delivery_address ?? $smartBuy->delivery_address) }}</textarea>

                                @error('delivery_address')

                                <span class="shipment-create-page__error">
                                        {{ $message }}
                                    </span>

                                @enderror

                            </div>

                        </div>

                    </div>

                </div>



                {{-- ====================================================
                    ADDITIONAL NOTES
                ===================================================== --}}

                <div class="shipment-create-page__card">

                    <div class="shipment-create-page__card-header">

                        <div class="shipment-create-page__card-title">

                            <div class="shipment-create-page__card-icon">

                                <i class="fa-solid fa-note-sticky"></i>

                            </div>


                            <div>

                                <h2>
                                    Additional Notes
                                </h2>

                                <p>
                                    Update any internal shipping or delivery notes.
                                </p>

                            </div>

                        </div>

                    </div>


                    <div class="shipment-create-page__card-body">

                        <div class="shipment-create-page__field">

                            <textarea
                                name="notes"
                                id="notes"
                                rows="5"
                                placeholder="Add additional shipment notes..."
                            >{{ old('notes', $shipment->notes) }}</textarea>

                            @error('notes')

                            <span class="shipment-create-page__error">
                                    {{ $message }}
                                </span>

                            @enderror

                        </div>

                    </div>

                </div>

            </form>



            {{-- ========================================================
                RIGHT SIDEBAR
            ========================================================= --}}

            <aside class="shipment-create-page__sidebar">


                {{-- ====================================================
                    PRODUCTS & COST SUMMARY
                ===================================================== --}}

                <div class="shipment-create-page__summary-card">

                    <div class="shipment-create-page__summary-header">

                        <div>

                            <h2>
                                Products
                            </h2>

                            <p>
                                Items included in this shipment
                            </p>

                        </div>


                        <span class="shipment-create-page__count">

                            {{ $productCount }}

                        </span>

                    </div>


                    <div class="shipment-create-page__product-list">


                        @forelse($quoteItems as $quoteItem)

                            @php

                                $product =
                                    $quoteItem->smartBuyItem
                                    ?? null;


                                $productImage =
                                    $quoteItem->product_image
                                    ?? $quoteItem->image
                                    ?? $product?->product_image
                                    ?? $product?->image
                                    ?? $product?->image_url
                                    ?? null;


                                $productName =
                                    $quoteItem->product_name
                                    ?? $product?->product_name
                                    ?? $product?->name
                                    ?? 'Product';


                                $quantity =
                                    (float) (
                                        $quoteItem->quantity
                                        ?? $product?->quantity
                                        ?? 1
                                    );


                                $unitPrice =
                                    (float) (
                                        $quoteItem->unit_price
                                        ?? $quoteItem->price
                                        ?? 0
                                    );


                                $itemTotal =
                                    (float) (
                                        $quoteItem->total_price
                                        ?? $quoteItem->total_amount
                                        ?? $quoteItem->total
                                        ?? (
                                            $unitPrice
                                            *
                                            $quantity
                                        )
                                    );


                                $size =
                                    $quoteItem->size
                                    ?? $product?->size
                                    ?? null;


                                $color =
                                    $quoteItem->color
                                    ?? $product?->color
                                    ?? null;

                            @endphp


                            <div class="shipment-create-page__product">


                                <div class="shipment-create-page__product-image">

                                    @if($productImage)

                                        <img
                                            src="{{ asset($productImage) }}"
                                            alt="{{ $productName }}"
                                        >

                                    @else

                                        <div class="shipment-create-page__product-placeholder">

                                            <i class="fa-solid fa-image"></i>

                                        </div>

                                    @endif

                                </div>


                                <div class="shipment-create-page__product-content">

                                    <h3>
                                        {{ $productName }}
                                    </h3>


                                    <div class="shipment-create-page__product-meta">

                                        <span>

                                            Qty:
                                            {{ $quantity == (int) $quantity ? (int) $quantity : $quantity }}

                                        </span>


                                        @if(!empty($size))

                                            <span>
                                                Size: {{ $size }}
                                            </span>

                                        @endif


                                        @if(!empty($color))

                                            <span>
                                                Color: {{ $color }}
                                            </span>

                                        @endif

                                    </div>


                                    <div class="shipment-create-page__product-price">

                                        <span>
                                            Unit Price
                                        </span>

                                        <strong>

                                            {{ $currency }}
                                            {{ number_format($unitPrice, 2) }}

                                        </strong>

                                    </div>


                                    <div class="shipment-create-page__product-total">

                                        <span>
                                            Item Total
                                        </span>

                                        <strong>

                                            {{ $currency }}
                                            {{ number_format($itemTotal, 2) }}

                                        </strong>

                                    </div>

                                </div>

                            </div>

                        @empty


                            @forelse($smartBuy->items as $item)

                                @php

                                    $productImage =
                                        $item->product_image
                                        ?? $item->image
                                        ?? $item->image_url
                                        ?? null;


                                    $productName =
                                        $item->product_name
                                        ?? $item->name
                                        ?? 'Product';


                                    $quantity =
                                        (float) (
                                            $item->quantity
                                            ?? 1
                                        );

                                @endphp


                                <div class="shipment-create-page__product">

                                    <div class="shipment-create-page__product-image">

                                        @if($productImage)

                                            <img
                                                src="{{ asset($productImage) }}"
                                                alt="{{ $productName }}"
                                            >

                                        @else

                                            <div class="shipment-create-page__product-placeholder">

                                                <i class="fa-solid fa-image"></i>

                                            </div>

                                        @endif

                                    </div>


                                    <div class="shipment-create-page__product-content">

                                        <h3>
                                            {{ $productName }}
                                        </h3>


                                        <div class="shipment-create-page__product-meta">

                                            <span>
                                                Qty: {{ $quantity }}
                                            </span>


                                            @if(!empty($item->size))

                                                <span>
                                                    Size: {{ $item->size }}
                                                </span>

                                            @endif


                                            @if(!empty($item->color))

                                                <span>
                                                    Color: {{ $item->color }}
                                                </span>

                                            @endif

                                        </div>


                                        <div class="shipment-create-page__product-price">

                                            <span>
                                                Unit Price
                                            </span>

                                            <strong>
                                                {{ $currency }} 0.00
                                            </strong>

                                        </div>


                                        <div class="shipment-create-page__product-total">

                                            <span>
                                                Item Total
                                            </span>

                                            <strong>
                                                {{ $currency }} 0.00
                                            </strong>

                                        </div>

                                    </div>

                                </div>

                            @empty

                                <div class="shipment-create-page__empty-products">

                                    <i class="fa-solid fa-box-open"></i>

                                    <span>
                                        No products available.
                                    </span>

                                </div>

                            @endforelse

                        @endforelse

                    </div>



                    {{-- ====================================================
                        COST SUMMARY
                    ===================================================== --}}

                    <div class="shipment-create-page__cost-summary">


                        <div class="shipment-create-page__cost-row">

                            <span>
                                Product Subtotal
                            </span>

                            <strong>

                                {{ $currency }}
                                {{ number_format($productSubtotal, 2) }}

                            </strong>

                        </div>


                        @if($serviceFee > 0)

                            <div class="shipment-create-page__cost-row">

                                <span>
                                    Service Fee
                                </span>

                                <strong>

                                    {{ $currency }}
                                    {{ number_format($serviceFee, 2) }}

                                </strong>

                            </div>

                        @endif


                        <div class="shipment-create-page__cost-row shipment-create-page__cost-row--shipping">

                            <div>

                                <i class="fa-solid fa-truck"></i>

                                <span>
                                    Shipping Cost
                                </span>

                            </div>


                            <strong>

                                {{ $currency }}
                                {{ number_format($shippingCost, 2) }}

                            </strong>

                        </div>


                        <div class="shipment-create-page__cost-total">

                            <span>
                                Total Amount
                            </span>

                            <strong>

                                {{ $currency }}
                                {{ number_format($orderTotal, 2) }}

                            </strong>

                        </div>

                    </div>

                </div>



                {{-- ====================================================
                    UPDATE SHIPMENT
                ===================================================== --}}

                <div class="shipment-create-page__action-card">

                    <div class="shipment-create-page__action-content">

                        <div class="shipment-create-page__action-icon">

                            <i class="fa-solid fa-pen-to-square"></i>

                        </div>


                        <div>

                            <h2>
                                Ready to Update?
                            </h2>

                            <p>
                                Review the shipment and product details before saving your changes.
                            </p>

                        </div>

                    </div>


                    <div class="shipment-create-page__actions">


                        {{-- Cancel --}}

                        <a
                            href="{{ route('smart-buy.details', $smartBuy->id) }}"
                            class="shipment-create-page__cancel-btn"
                        >

                            Cancel

                        </a>



                        {{-- Update Shipment --}}

                        <button
                            type="submit"
                            form="editShipmentForm"
                            class="shipment-create-page__submit-btn"
                            id="updateShipmentButton"
                        >

                            <i class="fa-solid fa-check"></i>

                            <span>
                                Update Shipment
                            </span>

                        </button>

                    </div>

                </div>

            </aside>

        </div>

    </div>

@endsection


@section('scripts')

    <script>

        document.addEventListener(
            'DOMContentLoaded',
            function () {

                const form =
                    document.getElementById(
                        'editShipmentForm'
                    );


                const button =
                    document.getElementById(
                        'updateShipmentButton'
                    );


                if (
                    !form ||
                    !button
                ) {

                    return;

                }


                form.addEventListener(
                    'submit',
                    function () {

                        /*
                        |--------------------------------------------------------------------------
                        | Prevent Double Submission
                        |--------------------------------------------------------------------------
                        */

                        if (
                            button.disabled
                        ) {

                            return;

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Disable Button
                        |--------------------------------------------------------------------------
                        */

                        button.disabled = true;


                        /*
                        |--------------------------------------------------------------------------
                        | Add Loading State
                        |--------------------------------------------------------------------------
                        */

                        button.classList.add(
                            'is-loading'
                        );


                        /*
                        |--------------------------------------------------------------------------
                        | Update Button Content
                        |--------------------------------------------------------------------------
                        */

                        button.innerHTML = `

                        <i
                            class="fa-solid fa-spinner fa-spin"
                        ></i>

                        <span>
                            Updating...
                        </span>

                    `;

                    }
                );

            }
        );

    </script>

@endsection
