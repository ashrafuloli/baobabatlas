@extends('backend.layouts.backend')

@section('title', 'Track Smart Buy')

@section('content')

    @php

        /*
        |--------------------------------------------------------------------------
        | Basic Data
        |--------------------------------------------------------------------------
        */

        $shipmentStatus = $shipment?->status
            ?? \App\Models\SmartBuyShipment::STATUS_PENDING;


        $shipmentNumber = $shipment?->shipment_number
            ?? (
                $shipment
                    ? 'SBS-' . str_pad(
                        $shipment->id,
                        6,
                        '0',
                        STR_PAD_LEFT
                    )
                    : 'Not available'
            );


        $requestNumber = $smartBuy->request_number
            ?? (
                'SB-' . str_pad(
                    $smartBuy->id,
                    6,
                    '0',
                    STR_PAD_LEFT
                )
            );


        /*
        |--------------------------------------------------------------------------
        | Quote
        |--------------------------------------------------------------------------
        */

        $quote = $smartBuy->latestQuote
            ?? $smartBuy->quote
            ?? null;


        /*
        |--------------------------------------------------------------------------
        | Quote Items
        |--------------------------------------------------------------------------
        */

        $quoteItems = $quote?->quoteItems
            ?? collect();


        /*
        |--------------------------------------------------------------------------
        | Smart Buy Items
        |--------------------------------------------------------------------------
        */

        $smartBuyItems = $smartBuy->items
            ?? collect();


        /*
        |--------------------------------------------------------------------------
        | Currency
        |--------------------------------------------------------------------------
        */

        $currency = $quote?->currency
            ?? $smartBuy->currency
            ?? 'USD';


        /*
        |--------------------------------------------------------------------------
        | Status Configuration
        |--------------------------------------------------------------------------
        */

        $trackingSteps = [

            [
                'key' => 'pending',
                'label' => 'Shipment Pending',
                'description' => 'Your shipment is being prepared.',
                'icon' => 'fa-clock',
            ],

            [
                'key' => 'preparing',
                'label' => 'Preparing Shipment',
                'description' => 'Your order is being prepared for dispatch.',
                'icon' => 'fa-box',
            ],

            [
                'key' => 'shipped',
                'label' => 'Shipped',
                'description' => 'Your shipment has been handed over to the carrier.',
                'icon' => 'fa-truck',
            ],

            [
                'key' => 'in_transit',
                'label' => 'In Transit',
                'description' => 'Your shipment is currently on the way.',
                'icon' => 'fa-truck-fast',
            ],

            [
                'key' => 'out_for_delivery',
                'label' => 'Out for Delivery',
                'description' => 'Your shipment is out for delivery.',
                'icon' => 'fa-location-dot',
            ],

            [
                'key' => 'delivered',
                'label' => 'Delivered',
                'description' => 'Your shipment has been successfully delivered.',
                'icon' => 'fa-circle-check',
            ],

        ];


        /*
        |--------------------------------------------------------------------------
        | Current Status Index
        |--------------------------------------------------------------------------
        */

        $currentStepIndex = 0;


        foreach ($trackingSteps as $index => $step) {

            if ($step['key'] === $shipmentStatus) {

                $currentStepIndex = $index;

                break;

            }

        }


        /*
        |--------------------------------------------------------------------------
        | Dates
        |--------------------------------------------------------------------------
        */

        $shippedAt = $shipment?->shipped_at
            ? \Carbon\Carbon::parse($shipment->shipped_at)
            : null;


        $estimatedDeliveryAt = $shipment?->estimated_delivery_at
            ? \Carbon\Carbon::parse($shipment->estimated_delivery_at)
            : null;


        $deliveredAt = $shipment?->delivered_at
            ? \Carbon\Carbon::parse($shipment->delivered_at)
            : null;


        /*
        |--------------------------------------------------------------------------
        | Product Count
        |--------------------------------------------------------------------------
        */

        $productCount = $quoteItems->count() > 0
            ? $quoteItems->count()
            : $smartBuyItems->count();


        /*
        |--------------------------------------------------------------------------
        | Status Label
        |--------------------------------------------------------------------------
        */

        $statusLabel = ucwords(
            str_replace(
                '_',
                ' ',
                $shipmentStatus
            )
        );

    @endphp


    <div class="my-smart-buy-tracking-page">


        {{-- ============================================================
            PAGE HEADER
        ============================================================ --}}

        <div class="my-smart-buy-tracking-page__header">

            <div class="my-smart-buy-tracking-page__header-left">

                <a
                    href="{{ route('my-smart-buy.details', $smartBuy->id) }}"
                    class="my-smart-buy-tracking-page__back"
                >

                    <i class="fa-solid fa-arrow-left"></i>

                    <span>
                        Back to Smart Buy
                    </span>

                </a>


                <div class="my-smart-buy-tracking-page__title">

                    <div class="my-smart-buy-tracking-page__title-icon">

                        <i class="fa-solid fa-truck-fast"></i>

                    </div>


                    <div>

                        <h1>
                            Track Your Smart Buy
                        </h1>

                        <p>
                            Follow the current delivery status of your request.
                        </p>

                    </div>

                </div>

            </div>


            <div class="my-smart-buy-tracking-page__request">

                <span>
                    Smart Buy Number
                </span>

                <strong>
                    {{ $requestNumber }}
                </strong>

            </div>

        </div>



        {{-- ============================================================
            SHIPMENT STATUS
        ============================================================ --}}

        <div class="my-smart-buy-tracking-page__status-card">

            <div class="my-smart-buy-tracking-page__status-header">

                <div>

                    <span class="my-smart-buy-tracking-page__eyebrow">
                        Current Shipment Status
                    </span>

                    <h2>
                        {{ $statusLabel }}
                    </h2>

                </div>


                <div
                    class="my-smart-buy-tracking-page__status-badge my-smart-buy-tracking-page__status-badge--{{ $shipmentStatus }}"
                >

                    <span></span>

                    {{ $statusLabel }}

                </div>

            </div>


            <div class="my-smart-buy-tracking-page__shipment-reference">

                <div class="d-none">

                    <span>
                        Smart Buy Request
                    </span>

                    <strong>
                        {{ $requestNumber }}
                    </strong>

                </div>


                <div class="d-none">

                    <span>
                        Shipment Reference
                    </span>

                    <strong>
                        {{ $shipmentNumber }}
                    </strong>

                </div>

            </div>

        </div>



        {{-- ============================================================
            TRACKING PROGRESS
        ============================================================ --}}

        @if($shipmentStatus !== \App\Models\SmartBuyShipment::STATUS_CANCELLED)

            <div class="my-smart-buy-tracking-page__progress-card">

                <div class="my-smart-buy-tracking-page__card-heading">

                    <div>

                        <h2>
                            Shipment Progress
                        </h2>

                        <p>
                            Follow each stage of your delivery.
                        </p>

                    </div>

                </div>


                <div class="my-smart-buy-tracking-page__timeline">

                    @foreach($trackingSteps as $index => $step)

                        @php

                            $isCompleted = $index < $currentStepIndex;

                            $isCurrent = $index === $currentStepIndex;

                        @endphp


                        <div
                            class="my-smart-buy-tracking-page__timeline-item {{ $isCompleted ? 'is-completed' : '' }} {{ $isCurrent ? 'is-current' : '' }}"
                        >

                            <div class="my-smart-buy-tracking-page__timeline-marker">

                                <i class="fa-solid {{ $step['icon'] }}"></i>

                            </div>


                            <div class="my-smart-buy-tracking-page__timeline-content">

                                <h3>
                                    {{ $step['label'] }}
                                </h3>

                                <p>
                                    {{ $step['description'] }}
                                </p>

                            </div>

                        </div>

                    @endforeach

                </div>

            </div>

        @else

            <div class="my-smart-buy-tracking-page__cancelled-card">

                <div class="my-smart-buy-tracking-page__cancelled-icon">

                    <i class="fa-solid fa-circle-xmark"></i>

                </div>


                <div>

                    <h2>
                        Shipment Cancelled
                    </h2>

                    <p>
                        This shipment has been cancelled.
                        Please contact support if you need assistance.
                    </p>

                </div>

            </div>

        @endif



        {{-- ============================================================
            MAIN GRID
        ============================================================ --}}

        <div class="my-smart-buy-tracking-page__grid">


            {{-- Shipment Details --}}

            <div class="my-smart-buy-tracking-page__details-card">

                <div class="my-smart-buy-tracking-page__card-heading">

                    <div>

                        <h2>
                            Shipment Details
                        </h2>

                        <p>
                            Important information about your delivery.
                        </p>

                    </div>

                </div>


                <div class="my-smart-buy-tracking-page__details-list">


                    <div class="my-smart-buy-tracking-page__detail-item">

                        <span>
                            Smart Buy Number
                        </span>

                        <strong>
                            {{ $requestNumber }}
                        </strong>

                    </div>


                    <div class="my-smart-buy-tracking-page__detail-item">

                        <span>
                            Carrier
                        </span>

                        <strong>
                            {{ $shipment?->carrier ?? 'Not specified' }}
                        </strong>

                    </div>


                    <div class="my-smart-buy-tracking-page__detail-item">

                        <span>
                            Shipping Method
                        </span>

                        <strong>
                            {{ $shipment?->shipping_method ?? 'Not specified' }}
                        </strong>

                    </div>


                    <div class="my-smart-buy-tracking-page__detail-item">

                        <span>
                            Shipped Date
                        </span>

                        <strong>
                            {{ $shippedAt ? $shippedAt->format('M d, Y h:i A') : 'Not shipped yet' }}
                        </strong>

                    </div>


                    <div class="my-smart-buy-tracking-page__detail-item">

                        <span>
                            Estimated Delivery
                        </span>

                        <strong>
                            {{ $estimatedDeliveryAt ? $estimatedDeliveryAt->format('M d, Y h:i A') : 'Not available' }}
                        </strong>

                    </div>


                    @if($deliveredAt)

                        <div class="my-smart-buy-tracking-page__detail-item">

                            <span>
                                Delivered On
                            </span>

                            <strong>
                                {{ $deliveredAt->format('M d, Y h:i A') }}
                            </strong>

                        </div>

                    @endif

                </div>

            </div>



            {{-- Delivery Address --}}

            <div class="my-smart-buy-tracking-page__address-card">

                <div class="my-smart-buy-tracking-page__card-heading">

                    <div>

                        <h2>
                            Delivery Address
                        </h2>

                        <p>
                            Your shipment destination.
                        </p>

                    </div>

                </div>


                <div class="my-smart-buy-tracking-page__address">

                    <div class="my-smart-buy-tracking-page__address-icon">

                        <i class="fa-solid fa-location-dot"></i>

                    </div>


                    <div>

                        <strong>

                            {{
                                $shipment?->delivery_address
                                ?? $smartBuy->delivery_address
                                ?? 'Address not available'
                            }}

                        </strong>


                        <span>

                            {{
                                collect([

                                    $shipment?->city
                                    ?? $smartBuy->city,

                                    $shipment?->zip_code
                                    ?? $smartBuy->zip_code,

                                    $shipment?->country
                                    ?? $smartBuy->country,

                                ])
                                ->filter()
                                ->implode(', ')
                            }}

                        </span>

                    </div>

                </div>

            </div>

        </div>



        {{-- ============================================================
            PRODUCTS
        ============================================================ --}}

        <div class="my-smart-buy-tracking-page__products-card">

            <div class="my-smart-buy-tracking-page__card-heading">

                <div>

                    <h2>
                        Products in This Shipment
                    </h2>

                    <p>

                        {{ $productCount }}

                        Item{{ $productCount !== 1 ? 's' : '' }}

                        included in this Smart Buy request.

                    </p>

                </div>

            </div>


            <div class="my-smart-buy-tracking-page__product-list">


                {{-- Quote Products --}}

                @forelse($quoteItems as $quoteItem)

                    @php

                        $product = $quoteItem->smartBuyItem;


                        $productImage =
                            $quoteItem->product_image
                            ?? $product?->product_image;


                        $productName = $quoteItem->product_name
                            ?? $product?->product_name
                            ?? $product?->name
                            ?? 'Product';


                        $quantity = (float) (
                            $quoteItem->quantity
                            ?? $product?->quantity
                            ?? 1
                        );


                        $unitPrice = (float) (
                            $quoteItem->unit_price
                            ?? $quoteItem->price
                            ?? 0
                        );


                        $totalPrice = $quoteItem->total_price
                            ?? $quoteItem->total_amount
                            ?? $quoteItem->total
                            ?? ($unitPrice * $quantity);

                    @endphp


                    <div class="my-smart-buy-tracking-page__product">

                        <div class="my-smart-buy-tracking-page__product-image">

                            @if($productImage)

                                <img
                                    src="{{ asset($productImage) }}"
                                    alt="{{ $productName }}"
                                >

                            @else

                                <div class="my-smart-buy-tracking-page__product-placeholder">

                                    <i class="fa-solid fa-image"></i>

                                </div>

                            @endif

                        </div>


                        <div class="my-smart-buy-tracking-page__product-content">

                            <h3>
                                {{ $productName }}
                            </h3>


                            <div class="my-smart-buy-tracking-page__product-meta">

                                <span>
                                    Quantity: {{ $quantity }}
                                </span>


                                <span>
                                    Unit Price:
                                    {{ $currency }}
                                    {{ number_format($unitPrice, 2) }}
                                </span>

                            </div>

                        </div>


                        <div class="my-smart-buy-tracking-page__product-price">

                            <span>
                                Total
                            </span>

                            <strong>

                                {{ $currency }}

                                {{
                                    number_format(
                                        (float) $totalPrice,
                                        2
                                    )
                                }}

                            </strong>

                        </div>

                    </div>


                    {{-- Fallback Smart Buy Items --}}

                @empty

                    @forelse($smartBuyItems as $item)

                        @php

                            $productImage = $item->product_image
                                ?? $item->image
                                ?? $item->image_url;


                            $productName = $item->product_name
                                ?? $item->name
                                ?? 'Product';


                            $quantity = (float) (
                                $item->quantity
                                ?? 1
                            );


                            $unitPrice = (float) (
                                $item->unit_price
                                ?? $item->price
                                ?? 0
                            );


                            $totalPrice = $unitPrice * $quantity;

                        @endphp


                        <div class="my-smart-buy-tracking-page__product">

                            <div class="my-smart-buy-tracking-page__product-image">

                                @if($productImage)

                                    <img
                                        src="{{ asset($productImage) }}"
                                        alt="{{ $productName }}"
                                    >

                                @else

                                    <div class="my-smart-buy-tracking-page__product-placeholder">

                                        <i class="fa-solid fa-image"></i>

                                    </div>

                                @endif

                            </div>


                            <div class="my-smart-buy-tracking-page__product-content">

                                <h3>
                                    {{ $productName }}
                                </h3>


                                <div class="my-smart-buy-tracking-page__product-meta">

                                    <span>
                                        Quantity: {{ $quantity }}
                                    </span>


                                    <span>

                                        Unit Price:

                                        {{ $currency }}

                                        {{ number_format($unitPrice, 2) }}

                                    </span>

                                </div>

                            </div>


                            <div class="my-smart-buy-tracking-page__product-price">

                                <span>
                                    Total
                                </span>

                                <strong>

                                    {{ $currency }}

                                    {{ number_format($totalPrice, 2) }}

                                </strong>

                            </div>

                        </div>

                    @empty

                        <div class="my-smart-buy-tracking-page__empty">

                            <i class="fa-solid fa-box-open"></i>

                            <span>
                                No products found.
                            </span>

                        </div>

                    @endforelse

                @endforelse

            </div>

        </div>

    </div>

@endsection
