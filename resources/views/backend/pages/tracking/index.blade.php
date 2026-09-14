@extends('backend.layouts.backend')

@section('title', 'Track Your Order')

@section('content')

    <div class="global-tracking">

        {{-- ==========================================================
        | Hero
        =========================================================== --}}

        <section class="tracking-hero">

            <div class="container">

                <div class="tracking-hero__content">

                    <div class="tracking-icon">
                        <i class="ri-truck-line"></i>
                    </div>

                    <div class="tracking-hero__text">

                        <span class="tracking-eyebrow">
                            ORDER & SMART BUY TRACKING
                        </span>

                        <h1>
                            Track Your Order
                        </h1>

                        <p>
                            Enter your order number or Smart Buy number to check
                            your current shipment status.
                        </p>

                    </div>

                </div>

            </div>

        </section>


        {{-- ==========================================================
        | Search
        =========================================================== --}}

        <section class="tracking-search-section">

            <div class="container">

                <div class="tracking-search-card">

                    <div class="tracking-search-header">

                        <h2>
                            Track Your Shipment
                        </h2>

                        <p>
                            Enter your Order Number or Smart Buy Number.
                            For example:
                            <strong>ORD-000001</strong>
                            or
                            <strong>SB-000001</strong>
                        </p>

                    </div>


                    {{-- Error Message --}}

                    @if(session('error'))

                        <div class="tracking-alert tracking-alert--error">

                            <i class="ri-error-warning-line"></i>

                            <span>
                                {{ session('error') }}
                            </span>

                        </div>

                    @endif


                    {{-- Success Message --}}

                    @if(session('success'))

                        <div class="tracking-alert tracking-alert--success">

                            <i class="ri-checkbox-circle-line"></i>

                            <span>
                                {{ session('success') }}
                            </span>

                        </div>

                    @endif


                    {{-- Search Form --}}

                    <form
                        action="{{ route('global-tracking.search') }}"
                        method="POST"
                        class="tracking-search-form-wrapper"
                        id="trackingForm"
                    >

                        @csrf

                        <div class="tracking-search-form">

                            <div class="tracking-input-wrapper">

                                <i class="ri-search-line"></i>

                                <input
                                    type="text"
                                    name="tracking_number"
                                    id="trackingNumber"
                                    value="{{ old('tracking_number') }}"
                                    placeholder="Enter Order Number or Smart Buy Number"
                                    autocomplete="off"
                                    maxlength="255"
                                    required
                                >

                            </div>


                            <button
                                type="submit"
                                class="tracking-search-btn"
                                id="trackingButton"
                            >

                                <span class="button-text">
                                    Track Shipment
                                </span>

                                <span class="button-loader"></span>

                                <i class="ri-arrow-right-line button-icon"></i>

                            </button>

                        </div>


                        @error('tracking_number')

                        <div class="tracking-validation-error">

                            <i class="ri-error-warning-line"></i>

                            <span>
                                {{ $message }}
                            </span>

                        </div>

                        @enderror

                    </form>

                </div>

            </div>

        </section>


        {{-- ==========================================================
        | E-commerce Order Tracking Result
        =========================================================== --}}

        @if(
            isset($trackingType)
            && $trackingType === 'order'
            && isset($order)
            && $order
        )

            @php

                /*
                |--------------------------------------------------------------------------
                | Order Shipment
                |--------------------------------------------------------------------------
                */

                $orderShipment = $orderShipment ?? null;


                /*
                |--------------------------------------------------------------------------
                | Normalize Order Status
                |--------------------------------------------------------------------------
                |
                | IMPORTANT:
                |
                | E-commerce tracking is controlled ONLY by Order::status.
                |
                | Shipment status and delivery status must NOT override
                | the order progress.
                |
                */

                $orderStatus = strtolower(
                    trim((string) $order->status)
                );


                /*
                |--------------------------------------------------------------------------
                | Normalize Payment Status
                |--------------------------------------------------------------------------
                */

                $paymentStatus = strtolower(
                    trim((string) $order->payment_status)
                );


                /*
                |--------------------------------------------------------------------------
                | Shipment Status
                |--------------------------------------------------------------------------
                |
                | Shipment status is displayed only inside shipment details.
                | It does not control the main order progress.
                |
                */

                $orderShipmentStatus = $orderShipment?->status
                    ? strtolower(
                        trim((string) $orderShipment->status)
                    )
                    : null;


                /*
                |--------------------------------------------------------------------------
                | Delivery Status
                |--------------------------------------------------------------------------
                */

                $orderDeliveryStatus = $orderShipment?->delivery_status
                    ? strtolower(
                        trim((string) $orderShipment->delivery_status)
                    )
                    : null;


                /*
                |--------------------------------------------------------------------------
                | Order Status Label
                |--------------------------------------------------------------------------
                */

                $orderStatusLabel = ucfirst(
                    str_replace(
                        '_',
                        ' ',
                        $orderStatus
                    )
                );


                /*
                |--------------------------------------------------------------------------
                | Payment Status Label
                |--------------------------------------------------------------------------
                */

                $paymentStatusLabel = ucfirst(
                    str_replace(
                        '_',
                        ' ',
                        $paymentStatus
                    )
                );


                /*
                |--------------------------------------------------------------------------
                | Order Progress Steps
                |--------------------------------------------------------------------------
                |
                | These steps represent the E-commerce Order status flow.
                |
                | pending / paid
                |       ↓
                | processing
                |       ↓
                | shipped
                |       ↓
                | in_transit
                |       ↓
                | out_for_delivery
                |       ↓
                | delivered / completed
                |
                */

                $orderSteps = [

        [
            'key' => \App\Models\Order::STATUS_PENDING,
            'title' => 'Order Pending',
            'description' =>
                'Your order has been received and is awaiting processing.',
            'icon' => 'ri-time-line',
        ],

        [
            'key' => \App\Models\Order::STATUS_PAID,
            'title' => 'Order Paid',
            'description' =>
                'Your payment has been successfully confirmed.',
            'icon' => 'ri-checkbox-circle-line',
        ],

        [
            'key' => \App\Models\Order::STATUS_PROCESSING,
            'title' => 'Processing',
            'description' =>
                'Your order is currently being processed.',
            'icon' => 'ri-box-3-line',
        ],

        [
            'key' => \App\Models\Order::STATUS_SHIPPED,
            'title' => 'Shipped',
            'description' =>
                'Your order has been handed over to the carrier.',
            'icon' => 'ri-truck-line',
        ],

        [
            'key' => \App\Models\Order::STATUS_IN_TRANSIT,
            'title' => 'In Transit',
            'description' =>
                'Your shipment is currently on the way.',
            'icon' => 'ri-road-map-line',
        ],

        [
            'key' => \App\Models\Order::STATUS_OUT_FOR_DELIVERY,
            'title' => 'Out for Delivery',
            'description' =>
                'Your shipment is out for delivery.',
            'icon' => 'ri-map-pin-line',
        ],

        [
            'key' => \App\Models\Order::STATUS_DELIVERED,
            'title' => 'Delivered',
            'description' =>
                'Your order has been successfully delivered.',
            'icon' => 'ri-checkbox-circle-line',
        ],

        [
            'key' => \App\Models\Order::STATUS_COMPLETED,
            'title' => 'Completed',
            'description' =>
                'Your order has been completed successfully.',
            'icon' => 'ri-check-double-line',
        ],

    ];


                /*
                |--------------------------------------------------------------------------
                | Order Status Map
                |--------------------------------------------------------------------------
                |
                | IMPORTANT:
                |
                | This map follows Order model statuses.
                |
                */

                $statusMap = [

                    \App\Models\Order::STATUS_PENDING => 0,

                    \App\Models\Order::STATUS_PAID => 1,

                    \App\Models\Order::STATUS_PROCESSING => 2,

                    \App\Models\Order::STATUS_SHIPPED => 3,

                    \App\Models\Order::STATUS_IN_TRANSIT => 4,

                    \App\Models\Order::STATUS_OUT_FOR_DELIVERY => 5,

                    \App\Models\Order::STATUS_DELIVERED => 6,

                    \App\Models\Order::STATUS_COMPLETED => 7,

                ];


                /*
                |--------------------------------------------------------------------------
                | Cancelled / Failed Order
                |--------------------------------------------------------------------------
                */

                $isOrderCancelled =
                    $orderStatus === \App\Models\Order::STATUS_CANCELLED;


                $isOrderFailed =
                    $orderStatus === \App\Models\Order::STATUS_FAILED;


                $isOrderTerminal =
                    $isOrderCancelled
                    || $isOrderFailed;


                /*
                |--------------------------------------------------------------------------
                | Current Order Step
                |--------------------------------------------------------------------------
                |
                | ONLY Order::status controls the current step.
                |
                | Shipment status is intentionally NOT used here.
                |
                */

                $currentOrderStep = null;


                if (!$isOrderTerminal) {

                    $currentOrderStep =
                        $statusMap[$orderStatus] ?? 0;

                }


                /*
                |--------------------------------------------------------------------------
                | Progress Percentage
                |--------------------------------------------------------------------------
                */

               $progressPercentage = 0;

                if (
                    !$isOrderTerminal
                    && $currentOrderStep !== null
                    && count($orderSteps) > 1
                ) {
                    $progressPercentage = min(
                        100,
                        max(
                            0,
                            ($currentOrderStep / (count($orderSteps) - 1)) * 100
                        )
                    );
                }

                $progressPercentage = round($progressPercentage);

            @endphp


            <section
                class="tracking-result-section"
                id="trackingResult"
            >

                <div class="container">

                    {{-- ==================================================
                    | Order Information
                    ================================================== --}}

                    <div class="tracking-request-card">

                        <div class="tracking-request-info">

                            <span>
                                Order Number
                            </span>

                            <strong>
                                {{ $order->order_number }}
                            </strong>

                        </div>


                        <div
                            class="
                                tracking-current-status
                                {{ $isOrderCancelled ? 'is-cancelled' : '' }}
                                {{ $isOrderFailed ? 'is-failed' : '' }}
                            "
                        >

                            <span class="status-label">

                                @if($isOrderCancelled)

                                    Order Status

                                @elseif($isOrderFailed)

                                    Order Status

                                @else

                                    Current Order Status

                                @endif

                            </span>


                            <strong>

                                @if($isOrderCancelled)

                                    Cancelled

                                @elseif($isOrderFailed)

                                    Failed

                                @elseif($currentOrderStep !== null)

                                    {{ $orderSteps[$currentOrderStep]['title'] }}

                                @else

                                    {{ $orderStatusLabel }}

                                @endif

                            </strong>

                        </div>

                    </div>


                    {{-- ==================================================
                    | Order Progress
                    ================================================== --}}

                    <div class="tracking-progress-card">

                        <div class="tracking-progress-header">

                            <div>

                                <h2>
                                    Order Progress
                                </h2>

                                <p>
                                    Follow the progress of your order.
                                </p>

                            </div>


                            @if(!$isOrderTerminal)

                                <div class="tracking-progress-percentage">

                                    {{ round($progressPercentage) }}%

                                </div>

                            @endif

                        </div>


                        @if(!$isOrderTerminal)

                            <div class="shipment-progress-wrapper">

                                {{-- ==================================================
                                | Progress Line
                                ================================================== --}}

                                <div class="shipment-progress-line">

                                    <div
                                        class="shipment-progress-line__active"
                                        style="width: {{ $progressPercentage }}%"
                                    ></div>

                                </div>


                                {{-- ==================================================
                                | Progress Steps
                                ================================================== --}}

                                <div class="shipment-steps">

                                    @foreach(
                                        $orderSteps
                                        as $index => $step
                                    )

                                        @php

                                            $isCompleted =
                                                $index < $currentOrderStep;

                                            $isCurrent =
                                                $index === $currentOrderStep;

                                        @endphp


                                        <div
                                            class="
                                                shipment-step
                                                {{ $isCompleted ? 'is-completed' : '' }}
                                                {{ $isCurrent ? 'is-current' : '' }}
                                            "
                                        >

                                            <div class="shipment-step__icon">

                                                <i
                                                    class="{{ $step['icon'] }}"
                                                ></i>

                                            </div>


                                            <h4>
                                                {{ $step['title'] }}
                                            </h4>


                                            <p>
                                                {{ $step['description'] }}
                                            </p>

                                        </div>

                                    @endforeach

                                </div>

                            </div>

                        @elseif($isOrderCancelled)

                            <div class="tracking-cancelled-message">

                                <div class="tracking-cancelled-message__icon">

                                    <i class="ri-close-circle-line"></i>

                                </div>

                                <div>

                                    <h3>
                                        Order Cancelled
                                    </h3>

                                    <p>
                                        This order has been cancelled.
                                        Please contact support if you need
                                        further assistance.
                                    </p>

                                </div>

                            </div>

                        @elseif($isOrderFailed)

                            <div class="tracking-cancelled-message">

                                <div class="tracking-cancelled-message__icon">

                                    <i class="ri-error-warning-line"></i>

                                </div>

                                <div>

                                    <h3>
                                        Order Failed
                                    </h3>

                                    <p>
                                        This order could not be completed.
                                        Please contact support if you need
                                        further assistance.
                                    </p>

                                </div>

                            </div>

                        @endif

                    </div>


                    {{-- ==================================================
                    | Order Details
                    ================================================== --}}

                    <div class="tracking-details-grid">

                        {{-- ==================================================
                        | Order Information
                        ================================================== --}}

                        <div class="tracking-details-card">

                            <h3>
                                Order Information
                            </h3>


                            <div class="tracking-detail-row">

                                <span>
                                    Order Number
                                </span>

                                <strong>
                                    {{ $order->order_number }}
                                </strong>

                            </div>


                            <div class="tracking-detail-row">

                                <span>
                                    Order Date
                                </span>

                                <strong>
                                    {{ $order->created_at->format('d M Y') }}
                                </strong>

                            </div>


                            <div class="tracking-detail-row">

                                <span>
                                    Order Status
                                </span>

                                <strong>
                                    {{ $orderStatusLabel }}
                                </strong>

                            </div>


                            <div class="tracking-detail-row">

                                <span>
                                    Payment Status
                                </span>

                                <strong>
                                    {{ $paymentStatusLabel }}
                                </strong>

                            </div>


                            <div class="tracking-detail-row">

                                <span>
                                    Order Total
                                </span>

                                <strong>
                                    {{ $order->currency ?? 'USD' }}
                                    {{ number_format((float) $order->total, 2) }}
                                </strong>

                            </div>

                        </div>


                        {{-- ==================================================
                        | Shipment Information
                        ================================================== --}}

                        <div class="tracking-details-card">

                            <h3>
                                Shipment Information
                            </h3>


                            @if($orderShipment)

                                @if($orderShipment->shipment_number)

                                    <div class="tracking-detail-row">

                                        <span>
                                            Shipment Number
                                        </span>

                                        <strong>
                                            {{ $orderShipment->shipment_number }}
                                        </strong>

                                    </div>

                                @endif


                                @if($orderShipment->tracking_number)

                                    <div class="tracking-detail-row">

                                        <span>
                                            Tracking Number
                                        </span>

                                        <strong>
                                            {{ $orderShipment->tracking_number }}
                                        </strong>

                                    </div>

                                @endif


                                @if($orderShipment->carrier)

                                    <div class="tracking-detail-row">

                                        <span>
                                            Carrier
                                        </span>

                                        <strong>
                                            {{ $orderShipment->carrier }}
                                        </strong>

                                    </div>

                                @endif


                                @if($orderShipment->shipping_method)

                                    <div class="tracking-detail-row">

                                        <span>
                                            Shipping Method
                                        </span>

                                        <strong>
                                            {{ $orderShipment->shipping_method }}
                                        </strong>

                                    </div>

                                @endif


                                @if($orderShipment->status)

                                    <div class="tracking-detail-row">

                                        <span>
                                            Shipment Status
                                        </span>

                                        <strong>
                                            {{ ucfirst(
                                                str_replace(
                                                    '_',
                                                    ' ',
                                                    $orderShipment->status
                                                )
                                            ) }}
                                        </strong>

                                    </div>

                                @endif


                                @if($orderShipment->delivery_status)

                                    <div class="tracking-detail-row">

                                        <span>
                                            Delivery Status
                                        </span>

                                        <strong>
                                            {{ ucfirst(
                                                str_replace(
                                                    '_',
                                                    ' ',
                                                    $orderShipment->delivery_status
                                                )
                                            ) }}
                                        </strong>

                                    </div>

                                @endif


                                @if($orderShipment->shipped_at)

                                    <div class="tracking-detail-row">

                                        <span>
                                            Shipped Date
                                        </span>

                                        <strong>
                                            {{ \Carbon\Carbon::parse(
                                                $orderShipment->shipped_at
                                            )->format('d M Y') }}
                                        </strong>

                                    </div>

                                @endif


                                @if($orderShipment->estimated_delivery_at)

                                    <div class="tracking-detail-row">

                                        <span>
                                            Estimated Delivery
                                        </span>

                                        <strong>
                                            {{ \Carbon\Carbon::parse(
                                                $orderShipment->estimated_delivery_at
                                            )->format('d M Y') }}
                                        </strong>

                                    </div>

                                @endif


                                @if($orderShipment->delivered_at)

                                    <div class="tracking-detail-row">

                                        <span>
                                            Delivered Date
                                        </span>

                                        <strong>
                                            {{ \Carbon\Carbon::parse(
                                                $orderShipment->delivered_at
                                            )->format('d M Y') }}
                                        </strong>

                                    </div>

                                @endif

                            @else

                                <div class="tracking-not-available">

                                    <div class="tracking-not-available__icon">

                                        <i class="ri-truck-line"></i>

                                    </div>

                                    <p>
                                        Shipment tracking is not available yet.
                                    </p>

                                </div>

                            @endif

                        </div>

                    </div>


                    {{-- ==================================================
                    | Shipment Notes
                    ================================================== --}}

                    @if(
                        $orderShipment
                        &&
                        $orderShipment->notes
                    )

                        <div class="tracking-notes">

                            <h3>

                                <i class="ri-information-line"></i>

                                <span>
                                    Shipment Notes
                                </span>

                            </h3>

                            <p>
                                {{ $orderShipment->notes }}
                            </p>

                        </div>

                    @endif

                </div>

            </section>

        @endif


        {{-- ==========================================================
        | Smart Buy Tracking Result
        =========================================================== --}}

        @if(
            isset($trackingType)
            && $trackingType === 'smart-buy'
            && isset($smartBuy)
            && isset($shipment)
            && $smartBuy
            && $shipment
        )

            @php

                $shipmentSteps = [

                    [
                        'status' =>
                            \App\Models\SmartBuyShipment::STATUS_PENDING,

                        'title' =>
                            'Shipment Pending',

                        'description' =>
                            'Your shipment is being prepared.',

                        'icon' =>
                            'ri-time-line',
                    ],

                    [
                        'status' =>
                            \App\Models\SmartBuyShipment::STATUS_PREPARING,

                        'title' =>
                            'Preparing Shipment',

                        'description' =>
                            'Your order is being prepared for dispatch.',

                        'icon' =>
                            'ri-box-3-line',
                    ],

                    [
                        'status' =>
                            \App\Models\SmartBuyShipment::STATUS_SHIPPED,

                        'title' =>
                            'Shipped',

                        'description' =>
                            'Your shipment has been handed over to the carrier.',

                        'icon' =>
                            'ri-truck-line',
                    ],

                    [
                        'status' =>
                            \App\Models\SmartBuyShipment::STATUS_IN_TRANSIT,

                        'title' =>
                            'In Transit',

                        'description' =>
                            'Your shipment is currently on the way.',

                        'icon' =>
                            'ri-truck-fill',
                    ],

                    [
                        'status' =>
                            \App\Models\SmartBuyShipment::STATUS_OUT_FOR_DELIVERY,

                        'title' =>
                            'Out for Delivery',

                        'description' =>
                            'Your shipment is out for delivery.',

                        'icon' =>
                            'ri-map-pin-line',
                    ],

                    [
                        'status' =>
                            \App\Models\SmartBuyShipment::STATUS_DELIVERED,

                        'title' =>
                            'Delivered',

                        'description' =>
                            'Your shipment has been successfully delivered.',

                        'icon' =>
                            'ri-checkbox-circle-line',
                    ],

                ];


                /*
                |--------------------------------------------------------------------------
                | Current Smart Buy Step
                |--------------------------------------------------------------------------
                */

                $currentStep = collect($shipmentSteps)
                    ->search(
                        fn ($step) =>
                            $step['status'] === $shipment->status
                    );


                /*
                |--------------------------------------------------------------------------
                | Cancelled
                |--------------------------------------------------------------------------
                */

                $isCancelled =
                    $shipment->status
                    ===
                    \App\Models\SmartBuyShipment::STATUS_CANCELLED;


                if ($currentStep === false) {

                    $currentStep = 0;

                }


                /*
                |--------------------------------------------------------------------------
                | Progress Percentage
                |--------------------------------------------------------------------------
                */

                $progressPercentage =
                    count($shipmentSteps) > 1
                        ? (
                            $currentStep
                            /
                            (
                                count($shipmentSteps) - 1
                            )
                        ) * 100
                        : 0;

            @endphp


            <section
                class="tracking-result-section"
                id="trackingResult"
            >

                <div class="container">

                    {{-- ==================================================
                    | Request Information
                    ================================================== --}}

                    <div class="tracking-request-card">

                        <div class="tracking-request-info">

                            <span>
                                Smart Buy Number
                            </span>

                            <strong>
                                {{ $smartBuy->request_number }}
                            </strong>

                        </div>


                        <div
                            class="
                                tracking-current-status
                                {{ $isCancelled ? 'is-cancelled' : '' }}
                            "
                        >

                            <span class="status-label">

                                @if($isCancelled)

                                    Shipment Status

                                @else

                                    Current Shipment Status

                                @endif

                            </span>

                            <strong>

                                @if($isCancelled)

                                    Cancelled

                                @else

                                    {{ $shipmentSteps[$currentStep]['title'] }}

                                @endif

                            </strong>

                        </div>

                    </div>


                    {{-- ==================================================
                    | Shipment Progress
                    ================================================== --}}

                    <div class="tracking-progress-card">

                        <div class="tracking-progress-header">

                            <div>

                                <h2>
                                    Shipment Progress
                                </h2>

                                <p>
                                    Follow each stage of your delivery.
                                </p>

                            </div>


                            @if(!$isCancelled)

                                <div class="tracking-progress-percentage">

                                    {{ round($progressPercentage) }}%

                                </div>

                            @endif

                        </div>


                        @if(!$isCancelled)

                            <div class="shipment-progress-wrapper">

                                <div class="shipment-progress-line">

                                    <div
                                        class="shipment-progress-line__active"
                                        style="width: {{ $progressPercentage }}%"
                                    ></div>

                                </div>


                                <div class="shipment-steps">

                                    @foreach(
                                        $shipmentSteps
                                        as $index => $step
                                    )

                                        @php

                                            $isCompleted =
                                                $index < $currentStep;

                                            $isCurrent =
                                                $index === $currentStep;

                                        @endphp


                                        <div
                                            class="
                                                shipment-step
                                                {{ $isCompleted ? 'is-completed' : '' }}
                                                {{ $isCurrent ? 'is-current' : '' }}
                                            "
                                        >

                                            <div class="shipment-step__icon">

                                                <i
                                                    class="{{ $step['icon'] }}"
                                                ></i>

                                            </div>


                                            <h4>
                                                {{ $step['title'] }}
                                            </h4>


                                            <p>
                                                {{ $step['description'] }}
                                            </p>

                                        </div>

                                    @endforeach

                                </div>

                            </div>

                        @else

                            <div class="tracking-cancelled-message">

                                <div class="tracking-cancelled-message__icon">

                                    <i class="ri-close-circle-line"></i>

                                </div>

                                <div>

                                    <h3>
                                        Shipment Cancelled
                                    </h3>

                                    <p>
                                        This shipment has been cancelled.
                                        Please contact support if you need
                                        further assistance.
                                    </p>

                                </div>

                            </div>

                        @endif

                    </div>


                    {{-- ==================================================
                    | Shipment Details
                    ================================================== --}}

                    <div class="tracking-details-grid">

                        <div class="tracking-details-card">

                            <h3>
                                Shipment Information
                            </h3>


                            @if($shipment->shipment_number)

                                <div class="tracking-detail-row">

                                    <span>
                                        Shipment Number
                                    </span>

                                    <strong>
                                        {{ $shipment->shipment_number }}
                                    </strong>

                                </div>

                            @endif


                            @if($shipment->tracking_number)

                                <div class="tracking-detail-row">

                                    <span>
                                        Tracking Number
                                    </span>

                                    <strong>
                                        {{ $shipment->tracking_number }}
                                    </strong>

                                </div>

                            @endif


                            @if($shipment->carrier)

                                <div class="tracking-detail-row">

                                    <span>
                                        Carrier
                                    </span>

                                    <strong>
                                        {{ $shipment->carrier }}
                                    </strong>

                                </div>

                            @endif


                            @if($shipment->shipping_method)

                                <div class="tracking-detail-row">

                                    <span>
                                        Shipping Method
                                    </span>

                                    <strong>
                                        {{ $shipment->shipping_method }}
                                    </strong>

                                </div>

                            @endif


                            @if($shipment->shipped_at)

                                <div class="tracking-detail-row">

                                    <span>
                                        Shipped Date
                                    </span>

                                    <strong>
                                        {{ \Carbon\Carbon::parse(
                                            $shipment->shipped_at
                                        )->format('d M Y') }}
                                    </strong>

                                </div>

                            @endif


                            @if($shipment->estimated_delivery_at)

                                <div class="tracking-detail-row">

                                    <span>
                                        Estimated Delivery
                                    </span>

                                    <strong>
                                        {{ \Carbon\Carbon::parse(
                                            $shipment->estimated_delivery_at
                                        )->format('d M Y') }}
                                    </strong>

                                </div>

                            @endif


                            @if($shipment->delivered_at)

                                <div class="tracking-detail-row">

                                    <span>
                                        Delivered Date
                                    </span>

                                    <strong>
                                        {{ \Carbon\Carbon::parse(
                                            $shipment->delivered_at
                                        )->format('d M Y') }}
                                    </strong>

                                </div>

                            @endif

                        </div>

                    </div>


                    {{-- ==================================================
                    | Shipment Tracking Link
                    ================================================== --}}

                    @if($shipment->tracking_url)

                        <div class="tracking-external-link">

                            <a
                                href="{{ $shipment->tracking_url }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="tracking-track-button"
                            >

                                Track With Carrier

                                <i class="ri-external-link-line"></i>

                            </a>

                        </div>

                    @endif


                    {{-- ==================================================
                    | Shipment Notes
                    ================================================== --}}

                    @if($shipment->notes)

                        <div class="tracking-notes">

                            <h3>

                                <i class="ri-information-line"></i>

                                <span>
                                    Shipment Notes
                                </span>

                            </h3>

                            <p>
                                {{ $shipment->notes }}
                            </p>

                        </div>

                    @endif

                </div>

            </section>

        @endif

    </div>

@endsection


@push('scripts')

    <script>
        document.addEventListener(
            'DOMContentLoaded',
            function () {

                /*
                |--------------------------------------------------------------------------
                | Page Wrapper
                |--------------------------------------------------------------------------
                */

                const trackingPage =
                    document.querySelector(
                        '.global-tracking'
                    );


                if (!trackingPage) {
                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | Elements
                |--------------------------------------------------------------------------
                */

                const form =
                    trackingPage.querySelector(
                        '#trackingForm'
                    );

                const input =
                    trackingPage.querySelector(
                        '#trackingNumber'
                    );

                const button =
                    trackingPage.querySelector(
                        '#trackingButton'
                    );

                const trackingResult =
                    trackingPage.querySelector(
                        '#trackingResult'
                    );


                /*
                |--------------------------------------------------------------------------
                | Format Tracking Number
                |--------------------------------------------------------------------------
                */

                input?.addEventListener(
                    'input',
                    function () {

                        let value =
                            this.value
                                .toUpperCase()
                                .replace(
                                    /\s+/g,
                                    ''
                                );


                        /*
                        |--------------------------------------------------------------------------
                        | Allow Only Tracking Characters
                        |--------------------------------------------------------------------------
                        */

                        value =
                            value.replace(
                                /[^A-Z0-9-]/g,
                                ''
                            );


                        this.value = value;

                    }
                );


                /*
                |--------------------------------------------------------------------------
                | Submit Form
                |--------------------------------------------------------------------------
                */

                form?.addEventListener(
                    'submit',
                    function (event) {

                        const trackingNumber =
                            input?.value.trim();


                        if (!trackingNumber) {

                            event.preventDefault();

                            input?.focus();

                            return;

                        }


                        button?.classList.add(
                            'is-loading'
                        );


                        if (button) {

                            button.disabled = true;

                        }

                    }
                );


                /*
                |--------------------------------------------------------------------------
                | Scroll To Result
                |--------------------------------------------------------------------------
                */

                if (trackingResult) {

                    setTimeout(
                        function () {

                            trackingResult.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start',
                            });

                        },
                        200
                    );

                }

            }
        );
    </script>

@endpush
