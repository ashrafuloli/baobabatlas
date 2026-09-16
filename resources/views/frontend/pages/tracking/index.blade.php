@extends('frontend.layouts.frontend')

@section('contents')

    <div class="tracking-page">

        {{-- ==========================================================
        | Hero
        =========================================================== --}}

        <div
            class="c-hero-section"
            style="background-image: url('{{ asset('assets/img/bg/bg-1.jpg') }}');"
        >

            <div class="container">

                <div class="row align-items-center">

                    <div class="col-xl-6 col-lg-6 col-md-10">

                        <div class="c-hero-content">

                            <ul class="breadcrumb-wrap">

                                <li>

                                    <a href="{{ route('home') }}">
                                        Home
                                    </a>

                                </li>

                                <li>

                                    <span class="arrow">
                                        <i class="ri-arrow-right-line"></i>
                                    </span>

                                </li>

                                <li>

                                    <span class="current">
                                        Track Shipment
                                    </span>

                                </li>

                            </ul>


                            <h1 class="title">
                                Track Shipment
                            </h1>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- ==========================================================
        | Tracking Search
        =========================================================== --}}

        <section class="tracking-section">

            <div class="container">

                <div class="row align-items-center">

                    <div class="col-xl-6 col-md-7 m-b-xs-30">

                        <div class="section-heading m-b-30">

                            <span class="subtitle">
                                TRACK YOUR SHIPMENT
                            </span>

                            <h2>
                                Real-time Tracking, Total Peace of Mind
                            </h2>

                        </div>


                        {{-- ==================================================
                        | Error Message
                        ================================================== --}}

                        @if(session('error'))

                            <div class="tracking-alert">

                                <i class="ri-error-warning-line"></i>

                                <span>
                                    {{ session('error') }}
                                </span>

                            </div>

                        @endif


                        {{-- ==================================================
                        | Success Message
                        ================================================== --}}

                        @if(session('success'))

                            <div class="tracking-alert tracking-alert--success">

                                <i class="ri-checkbox-circle-line"></i>

                                <span>
                                    {{ session('success') }}
                                </span>

                            </div>

                        @endif


                        {{-- ==================================================
                        | Tracking Form
                        ================================================== --}}

                        <form
                            class="tracking-form"
                            id="trackingForm"
                            action="{{ route('tracking.search') }}"
                            method="POST"
                        >

                            @csrf


                            <div class="tracking-form__input-wrap">

                                <input
                                    type="text"
                                    name="tracking_number"
                                    id="trackingNumber"
                                    value="{{ old('tracking_number', old('request_number')) }}"
                                    placeholder="Enter your order or Smart Buy number"
                                    autocomplete="off"
                                    maxlength="255"
                                    required
                                >


                                @if(
                                    isset($trackingType)
                                    && $trackingType
                                )

                                    <button
                                        type="button"
                                        class="tracking-reset-input"
                                        id="resetInput"
                                        aria-label="Clear tracking number"
                                    >

                                        <i class="ri-close-line"></i>

                                    </button>

                                @endif

                            </div>


                            <button
                                type="submit"
                                id="trackingButton"
                            >

                                <span class="button-text">
                                    Track Now
                                </span>

                                <i class="ri-box-3-line"></i>

                            </button>

                        </form>


                        {{-- ==================================================
                        | Validation Error
                        ================================================== --}}

                        @error('tracking_number')

                        <div class="tracking-validation-error">

                            <i class="ri-error-warning-line"></i>

                            <span>
                                    {{ $message }}
                                </span>

                        </div>

                        @enderror


                        @error('request_number')

                        <div class="tracking-validation-error">

                            <i class="ri-error-warning-line"></i>

                            <span>
                                    {{ $message }}
                                </span>

                        </div>

                        @enderror


                        {{-- ==================================================
                        | Search Again
                        ================================================== --}}

                        @if(
                            isset($trackingType)
                            && $trackingType
                        )

                            <div class="tracking-search-actions">

                                <a
                                    href="{{ route('tracking') }}"
                                    class="tracking-reset-btn"
                                >

                                    <i class="ri-refresh-line"></i>

                                    Search Another Shipment

                                </a>

                            </div>

                        @endif

                    </div>


                    <div class="col-xl-6 col-md-5">

                        <div class="tracking-image">

                            <img
                                src="{{ asset('assets/img/thumb/thumb-3.webp') }}"
                                alt="Shipment Tracking"
                            >

                        </div>

                    </div>

                </div>

            </div>

        </section>


        {{-- ==========================================================
        | E-commerce Order Tracking
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

                $orderShipment = $orderShipment ?? $order->shipment;


                /*
                |--------------------------------------------------------------------------
                | Current Order Status
                |--------------------------------------------------------------------------
                |
                | IMPORTANT:
                |
                | E-commerce tracking is controlled ONLY by Order::status.
                |
                | Shipment status and delivery status do not override the
                | order progress.
                |
                */

                $currentOrderStatus = strtolower(
                    trim((string) $order->status)
                );


                /*
                |--------------------------------------------------------------------------
                | Order Progress Steps
                |--------------------------------------------------------------------------
                */

                $orderSteps = [

                    [
                        'status' =>
                            \App\Models\Order::STATUS_PENDING,

                        'title' =>
                            'Order Pending',

                        'description' =>
                            'Your order has been received and is awaiting processing.',

                        'icon' =>
                            'ri-time-line',
                    ],

                    [
                        'status' =>
                            \App\Models\Order::STATUS_PAID,

                        'title' =>
                            'Order Paid',

                        'description' =>
                            'Your order has been successfully confirmed.',

                        'icon' =>
                            'ri-checkbox-circle-line',
                    ],

                    [
                        'status' =>
                            \App\Models\Order::STATUS_PROCESSING,

                        'title' =>
                            'Processing',

                        'description' =>
                            'Your order is currently being processed.',

                        'icon' =>
                            'ri-loader-4-line',
                    ],

                    [
                        'status' =>
                            \App\Models\Order::STATUS_SHIPPED,

                        'title' =>
                            'Shipped',

                        'description' =>
                            'Your order has been handed over to the carrier.',

                        'icon' =>
                            'ri-truck-line',
                    ],

                    [
                        'status' =>
                            \App\Models\Order::STATUS_IN_TRANSIT,

                        'title' =>
                            'In Transit',

                        'description' =>
                            'Your shipment is currently on the way.',

                        'icon' =>
                            'ri-road-map-line',
                    ],

                    [
                        'status' =>
                            \App\Models\Order::STATUS_OUT_FOR_DELIVERY,

                        'title' =>
                            'Out for Delivery',

                        'description' =>
                            'Your shipment is out for delivery.',

                        'icon' =>
                            'ri-map-pin-line',
                    ],

                    [
                        'status' =>
                            \App\Models\Order::STATUS_DELIVERED,

                        'title' =>
                            'Delivered',

                        'description' =>
                            'Your order has been successfully delivered.',

                        'icon' =>
                            'ri-checkbox-circle-line',
                    ],

                    [
                        'status' =>
                            \App\Models\Order::STATUS_COMPLETED,

                        'title' =>
                            'Completed',

                        'description' =>
                            'Your order has been completed successfully.',

                        'icon' =>
                            'ri-check-double-line',
                    ],

                ];


                /*
                |--------------------------------------------------------------------------
                | Cancelled / Failed
                |--------------------------------------------------------------------------
                */

                $isCancelled =
                    $currentOrderStatus ===
                    \App\Models\Order::STATUS_CANCELLED;


                $isFailed =
                    $currentOrderStatus ===
                    \App\Models\Order::STATUS_FAILED;


                $isTerminal =
                    $isCancelled
                    || $isFailed;


                /*
                |--------------------------------------------------------------------------
                | Find Current Step
                |--------------------------------------------------------------------------
                */

                $currentStep = collect($orderSteps)
                    ->search(
                        fn (array $step): bool =>
                            $step['status'] === $currentOrderStatus
                    );


                /*
                |--------------------------------------------------------------------------
                | Fallback
                |--------------------------------------------------------------------------
                */

                if ($currentStep === false) {

                    $currentStep = 0;

                }


                /*
                |--------------------------------------------------------------------------
                | Last Step
                |--------------------------------------------------------------------------
                */

                $lastStep =
                    count($orderSteps) - 1;


                /*
                |--------------------------------------------------------------------------
                | Progress Percentage
                |--------------------------------------------------------------------------
                */

                $progressPercentage =
                    !$isTerminal
                    && $lastStep > 0
                        ? (
                            $currentStep
                            /
                            $lastStep
                        ) * 100
                        : 0;


                /*
                |--------------------------------------------------------------------------
                | Current Status Title
                |--------------------------------------------------------------------------
                */

                $currentStatusTitle =
                    $orderSteps[$currentStep]['title'];


                if ($isCancelled) {

                    $currentStatusTitle =
                        'Order Cancelled';

                }


                if ($isFailed) {

                    $currentStatusTitle =
                        'Order Failed';

                }


                /*
                |--------------------------------------------------------------------------
                | Status CSS Class
                |--------------------------------------------------------------------------
                */

                $statusClass =
                    str_replace(
                        '_',
                        '-',
                        $currentOrderStatus
                    );


                /*
                |--------------------------------------------------------------------------
                | Payment Status
                |--------------------------------------------------------------------------
                */

                $paymentStatus =
                    strtolower(
                        trim(
                            (string) $order->payment_status
                        )
                    );


                $paymentStatusLabel =
                    ucfirst(
                        str_replace(
                            '_',
                            ' ',
                            $paymentStatus
                        )
                    );

            @endphp


            <section
                class="tracking-result-section"
                id="trackingResult"
            >

                <div class="container">


                    {{-- ======================================================
                    | Result Header
                    ====================================================== --}}

                    <div class="tracking-result-header">

                        <div>

                            <span class="subtitle">
                                E-COMMERCE ORDER
                            </span>

                            <h2>
                                Your Order Progress
                            </h2>

                        </div>


                        <div class="tracking-result-header__actions">

                            <div
                                class="
                                    tracking-status-badge
                                    tracking-status-badge--{{ $statusClass }}
                                "
                            >

                                {{ $currentStatusTitle }}

                            </div>


                            <a
                                href="{{ route('tracking') }}"
                                class="tracking-result-reset-btn"
                            >

                                <i class="ri-refresh-line"></i>

                                New Search

                            </a>

                        </div>

                    </div>


                    {{-- ======================================================
                    | Order Information
                    ====================================================== --}}

                    <div class="tracking-number-card">


                        <div class="tracking-number-card__item">

                            <span>
                                Order Number
                            </span>

                            <strong>
                                {{ $order->order_number }}
                            </strong>

                        </div>


                        @if(
                            $orderShipment
                            && $orderShipment->tracking_number
                        )

                            <div class="tracking-number-card__item">

                                <span>
                                    Tracking Number
                                </span>

                                <strong>
                                    {{ $orderShipment->tracking_number }}
                                </strong>

                            </div>

                        @endif


                        @if($order->created_at)

                            <div class="tracking-number-card__item">

                                <span>
                                    Order Date
                                </span>

                                <strong>
                                    {{ $order->created_at->format('d M Y') }}
                                </strong>

                            </div>

                        @endif

                    </div>


                    {{-- ======================================================
                    | Order Progress
                    ====================================================== --}}

                    <div class="tracking-progress">


                        <div class="tracking-progress__top">

                            <span>
                                Order Progress
                            </span>


                            @if(!$isTerminal)

                                <strong>
                                    {{ round($progressPercentage) }}%
                                </strong>

                            @endif

                        </div>


                        @if(!$isTerminal)

                            <div class="tracking-progress__line">

                                <div
                                    class="tracking-progress__active"
                                    style="width: {{ $progressPercentage }}%"
                                ></div>

                            </div>


                            <div class="tracking-progress__steps">

                                @foreach(
                                    $orderSteps
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
                                            tracking-step
                                            {{ $isCompleted ? 'is-completed' : '' }}
                                            {{ $isCurrent ? 'is-current' : '' }}
                                        "
                                    >

                                        <div class="tracking-step__icon">

                                            @if($isCompleted)

                                                <i class="ri-check-line"></i>

                                            @else

                                                <i
                                                    class="{{ $step['icon'] }}"
                                                ></i>

                                            @endif

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

                        @elseif($isCancelled)

                            <div class="tracking-alert tracking-alert--danger">

                                <i class="ri-close-circle-line"></i>

                                <span>
                                    This order has been cancelled.
                                </span>

                            </div>

                        @elseif($isFailed)

                            <div class="tracking-alert tracking-alert--danger">

                                <i class="ri-error-warning-line"></i>

                                <span>
                                    There was a problem processing this order.
                                </span>

                            </div>

                        @endif

                    </div>


                    {{-- ======================================================
                    | Order Details
                    ====================================================== --}}

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
                                    Order Status
                                </span>

                                <strong>
                                    {{ $currentStatusTitle }}
                                </strong>

                            </div>


                            @if($order->created_at)

                                <div class="tracking-detail-row">

                                    <span>
                                        Order Date
                                    </span>

                                    <strong>
                                        {{ $order->created_at->format('d M Y') }}
                                    </strong>

                                </div>

                            @endif


                            <div class="tracking-detail-row">

                                <span>
                                    Payment Status
                                </span>

                                <strong>
                                    {{ $paymentStatusLabel }}
                                </strong>

                            </div>


                            @if(isset($order->total))

                                <div class="tracking-detail-row">

                                    <span>
                                        Order Total
                                    </span>

                                    <strong>
                                        {{ $order->currency ?? 'USD' }}
                                        {{ number_format((float) $order->total, 2) }}
                                    </strong>

                                </div>

                            @endif

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

                            @else

                                <div class="tracking-not-available">

                                    <div class="tracking-not-available__icon">

                                        <i class="ri-truck-line"></i>

                                    </div>

                                    <p>
                                        Shipment information is not available yet.
                                    </p>

                                </div>

                            @endif

                        </div>

                    </div>


                    {{-- ======================================================
                    | Shipment Notes
                    ====================================================== --}}

                    @if(
                        $orderShipment
                        && $orderShipment->notes
                    )

                        <div class="tracking-notes">

                            <h3>

                                <i class="ri-information-line"></i>

                                Shipment Notes

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
        | Smart Buy Tracking
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

                /*
                |--------------------------------------------------------------------------
                | Smart Buy Shipment Steps
                |--------------------------------------------------------------------------
                */

                $smartBuySteps = [

                    [
                        'status' =>
                            \App\Models\SmartBuyShipment::STATUS_PENDING,

                        'title' =>
                            'Shipment Pending',

                        'description' =>
                            'Your shipment is awaiting preparation.',

                        'icon' =>
                            'ri-time-line',
                    ],

                    [
                        'status' =>
                            \App\Models\SmartBuyShipment::STATUS_PREPARING,

                        'title' =>
                            'Preparing',

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
                            'ri-road-map-line',
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
                | Current Smart Buy Status
                |--------------------------------------------------------------------------
                */

                $currentShipmentStatus =
                    strtolower(
                        trim(
                            (string) $shipment->status
                        )
                    );


                /*
                |--------------------------------------------------------------------------
                | Cancelled
                |--------------------------------------------------------------------------
                */

                $isSmartBuyCancelled =
                    $currentShipmentStatus ===
                    \App\Models\SmartBuyShipment::STATUS_CANCELLED;


                /*
                |--------------------------------------------------------------------------
                | Find Current Step
                |--------------------------------------------------------------------------
                */

                $smartBuyCurrentStep = collect($smartBuySteps)
                    ->search(
                        fn (array $step): bool =>
                            $step['status'] ===
                            $currentShipmentStatus
                    );


                if ($smartBuyCurrentStep === false) {

                    $smartBuyCurrentStep = 0;

                }


                /*
                |--------------------------------------------------------------------------
                | Progress
                |--------------------------------------------------------------------------
                */

                $smartBuyLastStep =
                    count($smartBuySteps) - 1;


                $smartBuyProgressPercentage =
                    !$isSmartBuyCancelled
                    && $smartBuyLastStep > 0
                        ? (
                            $smartBuyCurrentStep
                            /
                            $smartBuyLastStep
                        ) * 100
                        : 0;


                /*
                |--------------------------------------------------------------------------
                | Current Status Title
                |--------------------------------------------------------------------------
                */

                $smartBuyCurrentStatusTitle =
                    $smartBuySteps[$smartBuyCurrentStep]['title'];


                if ($isSmartBuyCancelled) {

                    $smartBuyCurrentStatusTitle =
                        'Shipment Cancelled';

                }


                /*
                |--------------------------------------------------------------------------
                | Status CSS Class
                |--------------------------------------------------------------------------
                */

                $smartBuyStatusClass =
                    str_replace(
                        '_',
                        '-',
                        $currentShipmentStatus
                    );

            @endphp


            <section
                class="tracking-result-section"
                id="trackingResult"
            >

                <div class="container">


                    {{-- ======================================================
                    | Result Header
                    ====================================================== --}}

                    <div class="tracking-result-header">

                        <div>

                            <span class="subtitle">
                                SMART BUY
                            </span>

                            <h2>
                                Your Shipment Progress
                            </h2>

                        </div>


                        <div class="tracking-result-header__actions">

                            <div
                                class="
                                    tracking-status-badge
                                    tracking-status-badge--{{ $smartBuyStatusClass }}
                                "
                            >

                                {{ $smartBuyCurrentStatusTitle }}

                            </div>


                            <a
                                href="{{ route('tracking') }}"
                                class="tracking-result-reset-btn"
                            >

                                <i class="ri-refresh-line"></i>

                                New Search

                            </a>

                        </div>

                    </div>


                    {{-- ======================================================
                    | Smart Buy Information
                    ====================================================== --}}

                    <div class="tracking-number-card">


                        <div class="tracking-number-card__item">

                            <span>
                                Smart Buy Number
                            </span>

                            <strong>
                                {{ $smartBuy->request_number }}
                            </strong>

                        </div>


                        @if($shipment->tracking_number)

                            <div class="tracking-number-card__item">

                                <span>
                                    Tracking Number
                                </span>

                                <strong>
                                    {{ $shipment->tracking_number }}
                                </strong>

                            </div>

                        @endif


                        @if($smartBuy->created_at)

                            <div class="tracking-number-card__item">

                                <span>
                                    Request Date
                                </span>

                                <strong>
                                    {{ $smartBuy->created_at->format('d M Y') }}
                                </strong>

                            </div>

                        @endif

                    </div>


                    {{-- ======================================================
                    | Smart Buy Progress
                    ====================================================== --}}

                    <div class="tracking-progress">


                        <div class="tracking-progress__top">

                            <span>
                                Shipment Progress
                            </span>


                            @if(!$isSmartBuyCancelled)

                                <strong>
                                    {{ round($smartBuyProgressPercentage) }}%
                                </strong>

                            @endif

                        </div>


                        @if(!$isSmartBuyCancelled)

                            <div class="tracking-progress__line">

                                <div
                                    class="tracking-progress__active"
                                    style="width: {{ $smartBuyProgressPercentage }}%"
                                ></div>

                            </div>


                            <div class="tracking-progress__steps">

                                @foreach(
                                    $smartBuySteps
                                    as $index => $step
                                )

                                    @php

                                        $isCompleted =
                                            $index < $smartBuyCurrentStep;

                                        $isCurrent =
                                            $index === $smartBuyCurrentStep;

                                    @endphp


                                    <div
                                        class="
                                            tracking-step
                                            {{ $isCompleted ? 'is-completed' : '' }}
                                            {{ $isCurrent ? 'is-current' : '' }}
                                        "
                                    >

                                        <div class="tracking-step__icon">

                                            @if($isCompleted)

                                                <i class="ri-check-line"></i>

                                            @else

                                                <i
                                                    class="{{ $step['icon'] }}"
                                                ></i>

                                            @endif

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

                        @else

                            <div class="tracking-alert tracking-alert--danger">

                                <i class="ri-close-circle-line"></i>

                                <span>
                                    This shipment has been cancelled.
                                </span>

                            </div>

                        @endif

                    </div>


                    {{-- ======================================================
                    | Smart Buy Shipment Details
                    ====================================================== --}}

                    <div class="tracking-details-grid">


                        <div class="tracking-details-card">

                            <h3>
                                Smart Buy Information
                            </h3>


                            <div class="tracking-detail-row">

                                <span>
                                    Smart Buy Number
                                </span>

                                <strong>
                                    {{ $smartBuy->request_number }}
                                </strong>

                            </div>


                            <div class="tracking-detail-row">

                                <span>
                                    Shipment Status
                                </span>

                                <strong>
                                    {{ $smartBuyCurrentStatusTitle }}
                                </strong>

                            </div>


                            @if($smartBuy->created_at)

                                <div class="tracking-detail-row">

                                    <span>
                                        Request Date
                                    </span>

                                    <strong>
                                        {{ $smartBuy->created_at->format('d M Y') }}
                                    </strong>

                                </div>

                            @endif

                        </div>


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


                    {{-- ======================================================
                    | Carrier Tracking
                    ====================================================== --}}

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


                    {{-- ======================================================
                    | Shipment Notes
                    ====================================================== --}}

                    @if($shipment->notes)

                        <div class="tracking-notes">

                            <h3>

                                <i class="ri-information-line"></i>

                                Shipment Notes

                            </h3>

                            <p>
                                {{ $shipment->notes }}
                            </p>

                        </div>

                    @endif

                </div>

            </section>

        @endif


        {{-- ==========================================================
        | FAQ
        =========================================================== --}}

        <section class="faq-section">

            <div class="container">

                <div class="row m-b-50">

                    <div class="col-xl-12">

                        <div class="section-heading text-center">

                            <span class="subtitle">
                                FAQ
                            </span>

                            <h2>
                                Frequently Asked Questions
                            </h2>

                        </div>

                    </div>

                </div>


                <div class="row">

                    <div class="col-xl-12">

                        <div class="faq-list">


                            <div class="faq-item">

                                <button
                                    type="button"
                                    class="faq-question"
                                >

                                    <span>
                                        How can I track my order?
                                    </span>

                                    <i class="ri-add-line"></i>

                                </button>


                                <div class="faq-answer">

                                    <div class="inner">

                                        <p>
                                            Enter your order number or Smart
                                            Buy number in the tracking form to
                                            view the latest available status.
                                        </p>

                                    </div>

                                </div>

                            </div>


                            <div class="faq-item">

                                <button
                                    type="button"
                                    class="faq-question"
                                >

                                    <span>
                                        How long does delivery take?
                                    </span>

                                    <i class="ri-add-line"></i>

                                </button>


                                <div class="faq-answer">

                                    <div class="inner">

                                        <p>
                                            Delivery time depends on your
                                            destination, shipping method and
                                            carrier.
                                        </p>

                                    </div>

                                </div>

                            </div>


                            <div class="faq-item">

                                <button
                                    type="button"
                                    class="faq-question"
                                >

                                    <span>
                                        Can I track my shipment in real time?
                                    </span>

                                    <i class="ri-add-line"></i>

                                </button>


                                <div class="faq-answer">

                                    <div class="inner">

                                        <p>
                                            Once tracking information becomes
                                            available, you can view the latest
                                            shipment status using your order or
                                            Smart Buy number.
                                        </p>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>


        {{-- ==========================================================
        | CTA
        =========================================================== --}}

        <section class="cta-section">

            <div class="container">

                <div class="row">

                    <div class="col-xl-12">

                        <div class="cta-content">

                            <div class="section-heading text-center">

                                <span class="subtitle">
                                    Get In Touch
                                </span>

                                <h2>
                                    Need a custom solution?
                                </h2>

                                <p class="description">
                                    We are here to help your business grow
                                    globally.
                                </p>

                            </div>


                            <div class="cta-btn">

                                <a href="{{route('contact')}}">

                                    Request a Quote <i class="ri-arrow-right-line"></i>

                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>

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
                        '.tracking-page'
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


                const resetInput =
                    trackingPage.querySelector(
                        '#resetInput'
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

                if (input) {

                    input.addEventListener(
                        'input',
                        function () {

                            this.value =
                                this.value
                                    .toUpperCase()
                                    .replace(
                                        /\s+/g,
                                        ''
                                    )
                                    .replace(
                                        /[^A-Z0-9-]/g,
                                        ''
                                    );

                        }
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | Clear Input
                |--------------------------------------------------------------------------
                */

                if (
                    resetInput
                    && input
                ) {

                    resetInput.addEventListener(
                        'click',
                        function () {

                            input.value = '';

                            input.focus();

                        }
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | Submit Form
                |--------------------------------------------------------------------------
                */

                if (
                    form
                    && input
                    && button
                ) {

                    form.addEventListener(
                        'submit',
                        function (event) {

                            const trackingNumber =
                                input.value.trim();


                            if (!trackingNumber) {

                                event.preventDefault();

                                input.focus();

                                return;

                            }


                            button.disabled = true;

                            button.classList.add(
                                'is-loading'
                            );

                        }
                    );

                }


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
                        300
                    );

                }

            }
        );

    </script>

@endpush
