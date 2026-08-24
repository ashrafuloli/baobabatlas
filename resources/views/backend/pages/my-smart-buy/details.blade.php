@extends('backend.layouts.backend')

@section('title', 'Smart Buy Details')

@section('content')

    @php

        /*
        |--------------------------------------------------------------------------
        | Status Configuration
        |--------------------------------------------------------------------------
        */

        $statusConfig = [

            'pending' => [

                'label' => 'Pending',

                'class' => 'pending',

                'progress' => 10,

            ],

            'quote_sent' => [

                'label' => 'Quote Sent',

                'class' => 'quote-sent',

                'progress' => 40,

            ],

            'quote_extension_requested' => [

                'label' => 'Quote Extension Requested',

                'class' => 'extension-requested',

                'progress' => 40,

            ],

            'quote_rejected' => [

                'label' => 'Quote Rejected',

                'class' => 'quote-rejected',

                'progress' => 40,

            ],

            'quote_accepted' => [

                'label' => 'Quote Accepted',

                'class' => 'quote-accepted',

                'progress' => 50,

            ],

            'payment_pending' => [

                'label' => 'Payment Pending',

                'class' => 'payment-pending',

                'progress' => 60,

            ],

            'payment_processing' => [

                'label' => 'Payment Processing',

                'class' => 'payment-processing',

                'progress' => 60,

            ],

            'payment_failed' => [

                'label' => 'Payment Failed',

                'class' => 'payment-failed',

                'progress' => 60,

            ],

            'payment_cancelled' => [

                'label' => 'Payment Cancelled',

                'class' => 'payment-cancelled',

                'progress' => 60,

            ],

            'payment_completed' => [

                'label' => 'Payment Completed',

                'class' => 'payment-completed',

                'progress' => 70,

            ],

            'product_purchased' => [

                'label' => 'Product Purchased',

                'class' => 'product-purchased',

                'progress' => 80,

            ],

            'in_transit' => [

                'label' => 'In Transit',

                'class' => 'in-transit',

                'progress' => 90,

            ],

            'completed' => [

                'label' => 'Completed',

                'class' => 'completed',

                'progress' => 100,

            ],

            'cancelled' => [

                'label' => 'Cancelled',

                'class' => 'cancelled',

                'progress' => 0,

            ],

        ];


        /*
        |--------------------------------------------------------------------------
        | Current Status
        |--------------------------------------------------------------------------
        */

        $currentStatus =
            $statusConfig[$smartBuy->status]
            ?? [
                'label' => ucfirst(
                    str_replace(
                        '_',
                        ' ',
                        $smartBuy->status
                    )
                ),
                'class' => 'pending',
                'progress' => 0,
            ];


        /*
        |--------------------------------------------------------------------------
        | Country
        |--------------------------------------------------------------------------
        */

        $countryName =
            config(
                'countries.' . $smartBuy->country,
                $smartBuy->country
            );

    @endphp


    <div class="my-smart-buy-details">

        {{-- ============================================================
            Page Header
        ============================================================ --}}

        <div class="smart-buy-details__header">

            <div class="smart-buy-details__header-left">

                <a
                    href="{{ route('my-smart-buy') }}"
                    class="smart-buy-details__back"
                >
                    <i class="fa-regular fa-arrow-left"></i>
                    <span>Back to My Requests</span>
                </a>


                <div class="smart-buy-details__title-wrap">

                    <div class="smart-buy-details__icon">

                        <i class="fa-solid fa-bag-shopping"></i>

                    </div>


                    <div>

                        <h2>
                            Smart Buy Request
                        </h2>

                        <p>
                            {{ $smartBuy->request_number }}
                        </p>

                    </div>

                </div>

            </div>


            <div class="smart-buy-details__status">

            <span
                class="smart-buy-status smart-buy-status--{{ $currentStatus['class'] }}"
            >

                <span class="smart-buy-status__dot"></span>

                {{ $currentStatus['label'] }}

            </span>

            </div>

        </div>

        {{-- ============================================================
            SMART BUY REQUEST PROGRESS
        ============================================================ --}}

        @php

            /*
            |--------------------------------------------------------------------------
            | Progress Steps
            |--------------------------------------------------------------------------
            */

            $progressSteps = [

                [
                    'key' => 'request',
                    'label' => 'Request',
                    'icon' => 'fa-solid fa-file-lines',
                    'statuses' => [

                        'pending',

                        'quote_sent',
                        'quote_rejected',
                        'quote_accepted',
                        'quote_extension_requested',

                        'payment_pending',
                        'payment_processing',
                        'payment_failed',
                        'payment_cancelled',
                        'payment_completed',

                        'product_purchased',

                        'in_transit',

                        'completed',

                    ],
                ],

                [
                    'key' => 'quote',
                    'label' => 'Quote',
                    'icon' => 'fa-solid fa-file-invoice-dollar',
                    'statuses' => [

                        'quote_sent',

                        'quote_rejected',

                        'quote_extension_requested',

                        'quote_accepted',

                        'payment_pending',
                        'payment_processing',
                        'payment_failed',
                        'payment_cancelled',
                        'payment_completed',

                        'product_purchased',

                        'in_transit',

                        'completed',

                    ],
                ],

                [
                    'key' => 'payment',
                    'label' => 'Payment',
                    'icon' => 'fa-solid fa-credit-card',
                    'statuses' => [

                        'quote_accepted',

                        'payment_pending',

                        'payment_processing',

                        'payment_failed',

                        'payment_cancelled',

                        'payment_completed',

                        'product_purchased',

                        'in_transit',

                        'completed',

                    ],
                ],

                [
                    'key' => 'shipping',
                    'label' => 'Shipping',
                    'icon' => 'fa-solid fa-truck',
                    'statuses' => [

                        'product_purchased',

                        'in_transit',

                        'completed',

                    ],
                ],

                [
                    'key' => 'completed',
                    'label' => 'Completed',
                    'icon' => 'fa-solid fa-circle-check',
                    'statuses' => [

                        'completed',

                    ],
                ],

            ];


            /*
            |--------------------------------------------------------------------------
            | Current Status
            |--------------------------------------------------------------------------
            */

            $currentStatus = $statusConfig[
                $smartBuy->status
            ] ?? [

                'label' => 'Unknown',
                'class' => 'unknown',
                'progress' => 0,

            ];


            /*
            |--------------------------------------------------------------------------
            | Terminal Statuses
            |--------------------------------------------------------------------------
            */

            $isTerminalStatus = in_array(
                $smartBuy->status,
                [

                    'cancelled',

                ],
                true
            );

        @endphp


        {{-- ============================================================
            REQUEST PROGRESS
        ============================================================ --}}

        <div class="smart-buy-progress-card">


            {{-- ========================================================
                HEADER
            ========================================================= --}}

            <div class="smart-buy-progress-card__header">

                <div class="smart-buy-progress-card__heading">

                    <div
                        class="
                    smart-buy-progress-card__status-icon
                    smart-buy-progress-card__status-icon--{{ $currentStatus['class'] }}
                "
                    >

                        @if($isTerminalStatus)

                            <i class="fa-solid fa-circle-xmark"></i>

                        @else

                            <i class="fa-solid fa-chart-line"></i>

                        @endif

                    </div>


                    <div>

                        <h3>
                            Request Progress
                        </h3>

                        <p>

                            {{
                                $isTerminalStatus
                                    ? $currentStatus['label']
                                    : 'Track the current progress of your Smart Buy request.'
                            }}

                        </p>

                    </div>

                </div>


                <div
                    class="
                smart-buy-progress-card__percentage
                {{
                    $isTerminalStatus
                        ? 'smart-buy-progress-card__percentage--terminal'
                        : ''
                }}
            "
                >

            <span>
                Progress
            </span>

                    <strong>
                        {{ $currentStatus['progress'] }}%
                    </strong>

                </div>

            </div>


            {{-- ========================================================
                PROGRESS CONTENT
            ========================================================= --}}

            <div class="smart-buy-progress">


                {{-- ====================================================
                    PROGRESS LINE
                ===================================================== --}}

                <div class="smart-buy-progress__line">

                    <div
                        class="
                    smart-buy-progress__active
                    {{
                        $isTerminalStatus
                            ? 'smart-buy-progress__active--terminal'
                            : ''
                    }}
                "
                        style="
                    width: {{ $currentStatus['progress'] }}%;
                "
                    ></div>

                </div>


                {{-- ====================================================
                    PROGRESS STEPS
                ===================================================== --}}

                <div class="smart-buy-progress__steps">

                    @foreach($progressSteps as $step)

                        @php

                            /*
                            |--------------------------------------------------------------------------
                            | Check Active Step
                            |--------------------------------------------------------------------------
                            */

                            $isActive = in_array(
                                $smartBuy->status,
                                $step['statuses'],
                                true
                            );


                            /*
                            |--------------------------------------------------------------------------
                            | Current Step
                            |--------------------------------------------------------------------------
                            */

                            $isCurrent = match($step['key']) {

                                /*
                                |--------------------------------------------------------------------------
                                | Request
                                |--------------------------------------------------------------------------
                                */

                                'request' =>

                                    $smartBuy->status === 'pending',


                                /*
                                |--------------------------------------------------------------------------
                                | Quote
                                |--------------------------------------------------------------------------
                                */

                                'quote' =>

                                    in_array(
                                        $smartBuy->status,
                                        [

                                            'quote_sent',

                                            'quote_rejected',

                                            'quote_extension_requested',

                                        ],
                                        true
                                    ),


                                /*
                                |--------------------------------------------------------------------------
                                | Payment
                                |--------------------------------------------------------------------------
                                */

                                'payment' =>

                                    in_array(
                                        $smartBuy->status,
                                        [

                                            'quote_accepted',

                                            'payment_pending',

                                            'payment_processing',

                                            'payment_failed',

                                            'payment_cancelled',

                                            'payment_completed',

                                        ],
                                        true
                                    ),


                                /*
                                |--------------------------------------------------------------------------
                                | Shipping
                                |--------------------------------------------------------------------------
                                */

                                'shipping' =>

                                    in_array(
                                        $smartBuy->status,
                                        [

                                            'product_purchased',

                                            'in_transit',

                                        ],
                                        true
                                    ),


                                /*
                                |--------------------------------------------------------------------------
                                | Completed
                                |--------------------------------------------------------------------------
                                */

                                'completed' =>

                                    $smartBuy->status === 'completed',


                                default => false,

                            };


                            /*
                            |--------------------------------------------------------------------------
                            | Step Class
                            |--------------------------------------------------------------------------
                            */

                            $stepClass = '';


                            if ($isTerminalStatus) {

                                $stepClass = 'is-terminal';

                            } elseif ($isCurrent) {

                                $stepClass = 'is-current';

                            } elseif ($isActive) {

                                $stepClass = 'is-active';

                            }

                        @endphp


                        <div
                            class="
                        smart-buy-progress__step
                        {{ $stepClass }}
                    "
                        >


                            {{-- STEP CIRCLE --}}

                            <span class="smart-buy-progress__circle">

                        <i
                            class="{{ $step['icon'] }}"
                        ></i>

                    </span>


                            {{-- STEP LABEL --}}

                            <span class="smart-buy-progress__label">

                        {{ $step['label'] }}

                    </span>


                            {{-- CURRENT INDICATOR --}}

                            @if(
                                $isCurrent
                                &&
                                !$isTerminalStatus
                            )

                                <span class="smart-buy-progress__current">

                            Current

                        </span>

                            @endif


                        </div>

                    @endforeach

                </div>


                {{-- ====================================================
                    CURRENT STATUS
                ===================================================== --}}

                @if(!$isTerminalStatus)

                    <div class="smart-buy-progress__status">

                        <div class="smart-buy-progress__status-info">

                    <span
                        class="smart-buy-progress__status-dot"
                    ></span>

                            <span>
                        Current Status
                    </span>

                        </div>


                        <strong>

                            {{ $currentStatus['label'] }}

                        </strong>

                    </div>

                @else

                    <div
                        class="
                    smart-buy-progress__status
                    smart-buy-progress__status--terminal
                "
                    >

                        <div class="smart-buy-progress__status-info">

                            <i class="fa-solid fa-circle-exclamation"></i>

                            <span>
                        Request Status
                    </span>

                        </div>


                        <strong>

                            {{ $currentStatus['label'] }}

                        </strong>

                    </div>

                @endif


            </div>

        </div>


        {{-- ============================================================
            Main Content
        ============================================================ --}}

        <div class="smart-buy-details__grid">


            {{-- ========================================================
                Left Content
            ======================================================== --}}

            <div class="smart-buy-details__main">


                {{-- ====================================================
                    Request Information
                ==================================================== --}}

                <div class="smart-buy-details-card">

                    <div class="smart-buy-details-card__header">

                        <div>

                        <span class="smart-buy-details-card__eyebrow">

                            Request Information

                        </span>

                            <h3>
                                Request Details
                            </h3>

                        </div>


                        <div class="smart-buy-details-card__date">

                            <i class="fa-regular fa-calendar"></i>

                            {{ $smartBuy->created_at->format('d M Y') }}

                        </div>

                    </div>


                    <div class="smart-buy-request-info">

                        <div class="smart-buy-request-info__item">

                        <span>
                            Request Number
                        </span>

                            <strong>
                                {{ $smartBuy->request_number }}
                            </strong>

                        </div>


                        <div class="smart-buy-request-info__item">

                        <span>
                            Total Products
                        </span>

                            <strong>
                                {{ $smartBuy->items->count() }}
                                {{ Str::plural('Item', $smartBuy->items->count()) }}
                            </strong>

                        </div>


                        <div class="smart-buy-request-info__item">

                        <span>
                            Country
                        </span>

                            <strong>
                                {{ $countryName }}
                            </strong>

                        </div>


                        <div class="smart-buy-request-info__item">

                        <span>
                            City
                        </span>

                            <strong>
                                {{ $smartBuy->city }}
                            </strong>

                        </div>

                    </div>

                </div>


                {{-- ====================================================
                    Requested Products
                ==================================================== --}}

                <div class="smart-buy-details-card">

                    <div class="smart-buy-details-card__header">

                        <div>

                        <span class="smart-buy-details-card__eyebrow">

                            Products

                        </span>

                            <h3>
                                Requested Products
                            </h3>

                        </div>


                        <span class="smart-buy-details-card__count">

                        {{ $smartBuy->items->count() }}

                            {{ Str::plural(
                                'Item',
                                $smartBuy->items->count()
                            ) }}

                    </span>

                    </div>


                    <div class="smart-buy-product-list">

                        @forelse($smartBuy->items as $item)

                            <div class="smart-buy-product">


                                {{-- Product Image --}}

                                <div class="smart-buy-product__image">

                                    @if($item->product_image)

                                        <img
                                            src="{{ asset($item->product_image) }}"
                                            alt="{{ $item->product_name }}"
                                        >

                                    @else

                                        <div class="smart-buy-product__placeholder">

                                            <i class="fa-solid fa-image"></i>

                                        </div>

                                    @endif

                                </div>


                                {{-- Product Content --}}

                                <div class="smart-buy-product__content">

                                <span class="smart-buy-product__label">

                                    Requested Product

                                </span>


                                    <h4>

                                        {{ $item->product_name }}

                                    </h4>


                                    <div class="smart-buy-product__meta">

                                    <span>

                                        Qty:

                                        <strong>
                                            {{ $item->quantity }}
                                        </strong>

                                    </span>


                                        @if($item->size)

                                            <span>

                                            Size:

                                            <strong>
                                                {{ $item->size }}
                                            </strong>

                                        </span>

                                        @endif


                                        @if($item->color)

                                            <span>

                                            Color:

                                            <strong>
                                                {{ $item->color }}
                                            </strong>

                                        </span>

                                        @endif

                                    </div>


                                    @if($item->notes)

                                        <div class="smart-buy-product__notes">

                                            {{ $item->notes }}

                                        </div>

                                    @endif


                                    @if($item->product_url)

                                        <a
                                            href="{{ $item->product_url }}"
                                            target="_blank"
                                            rel="noopener"
                                            class="smart-buy-product__link"
                                        >

                                            <i class="fa-solid fa-arrow-up-right-from-square"></i>

                                            View Product

                                        </a>

                                    @endif

                                </div>

                            </div>

                        @empty

                            <div class="smart-buy-empty">

                                <i class="fa-solid fa-box-open"></i>

                                <p>
                                    No products found for this request.
                                </p>

                            </div>

                        @endforelse

                    </div>

                </div>


                {{-- ====================================================
                    Quote
                ==================================================== --}}

                @if($smartBuy->quote)

                    <div class="smart-buy-details-card">

                        <div class="smart-buy-details-card__header">

                            <div>

                            <span class="smart-buy-details-card__eyebrow">

                                Pricing

                            </span>

                                <h3>
                                    Your Quote
                                </h3>

                            </div>


                            <span class="smart-buy-quote-number">

                            {{ $smartBuy->quote->quote_number }}

                        </span>

                        </div>


                        <div class="smart-buy-quote-summary">

                            <div class="smart-buy-quote-summary__row">

                            <span>
                                Product Total
                            </span>

                                <strong>
                                    {{ $smartBuy->quote->currency }}
                                    {{ number_format($smartBuy->quote->product_total, 2) }}
                                </strong>

                            </div>


                            <div class="smart-buy-quote-summary__row">

                            <span>
                                Service Fee
                            </span>

                                <strong>
                                    {{ $smartBuy->quote->currency }}
                                    {{ number_format($smartBuy->quote->service_fee, 2) }}
                                </strong>

                            </div>


                            <div class="smart-buy-quote-summary__row">

                            <span>
                                Shipping Fee
                            </span>

                                <strong>
                                    {{ $smartBuy->quote->currency }}
                                    {{ number_format($smartBuy->quote->shipping_fee, 2) }}
                                </strong>

                            </div>


                            @if($smartBuy->quote->discount > 0)

                                <div class="smart-buy-quote-summary__row is-discount">

                                <span>
                                    Discount
                                </span>

                                    <strong>

                                        -
                                        {{ $smartBuy->quote->currency }}
                                        {{ number_format($smartBuy->quote->discount, 2) }}

                                    </strong>

                                </div>

                            @endif


                            <div class="smart-buy-quote-summary__row is-total">

                            <span>
                                Total Amount
                            </span>

                                <strong>

                                    {{ $smartBuy->quote->currency }}
                                    {{ number_format(
                                        $smartBuy->quote->total_amount,
                                        2
                                    ) }}

                                </strong>

                            </div>

                        </div>


                        @if($smartBuy->quote->notes)

                            <div class="smart-buy-quote-note">

                                <i class="fa-solid fa-circle-info"></i>

                                <p>
                                    {{ $smartBuy->quote->notes }}
                                </p>

                            </div>

                        @endif


                        {{-- Quote Action --}}

                        @if(
                            in_array(
                                $smartBuy->status,
                                ['quote_sent','quote_extension_requested']
                            )
                        )

                            <div class="smart-buy-details-card__actions">

                                <a
                                    href="{{ route(
                                    'my-smart-buy.quote',
                                    $smartBuy
                                ) }}"
                                    class="smart-buy-btn smart-buy-btn--primary"
                                >

                                    <i class="fa-solid fa-file-invoice-dollar"></i>

                                    View & Respond to Quote

                                </a>

                            </div>

                        @endif

                    </div>

                @endif



                {{-- ====================================================
                    Payment
                ==================================================== --}}

                @if($smartBuy->payment)

                    <div class="smart-buy-details-card">
                        <div class="smart-buy-details-card__header">

                            <div>

                            <span class="smart-buy-details-card__eyebrow">

                                Payment

                            </span>

                                <h3>
                                    Payment Information
                                </h3>

                            </div>


                            <span
                                class="smart-buy-payment-status
                            smart-buy-payment-status--{{ $smartBuy->payment->status }}"
                            >

                            {{ ucfirst($smartBuy->payment->status) }}

                        </span>

                        </div>

                        <div class="smart-buy-payment-info">

                            <div>

                            <span>
                                Payment Number
                            </span>

                                <strong>
                                    {{ $smartBuy->payment->payment_number }}
                                </strong>

                            </div>


                            <div>

                            <span>
                                Amount
                            </span>

                                <strong>

                                    {{ $smartBuy->payment->currency }}
                                    {{ number_format(
                                        $smartBuy->payment->amount,
                                        2
                                    ) }}

                                </strong>

                            </div>


                            <div>

                            <span>
                                Payment Method
                            </span>

                                <strong>

                                    {{
                                        $smartBuy->payment->payment_method
                                        ?? '—'
                                    }}

                                </strong>

                            </div>


                            <div>

                            <span>
                                Paid Date
                            </span>

                                <strong>

                                    {{
                                        $smartBuy->payment->paid_at
                                            ? $smartBuy->payment
                                                ->paid_at
                                                ->format('d M Y')
                                            : '—'
                                    }}

                                </strong>

                            </div>

                        </div>
                    </div>

                @elseif($smartBuy->status === 'quote_accepted' || $smartBuy->status === 'payment_pending')

                    <div class="smart-buy-payment-required">

                        <div class="smart-buy-payment-required__icon">

                            <i class="fa-solid fa-credit-card"></i>

                        </div>


                        <div class="smart-buy-payment-required__content">

                            <h3>
                                Payment Required
                            </h3>

                            <p>
                                Your quote has been accepted. Please proceed with payment to continue your Smart Buy
                                request.
                            </p>

                        </div>


                        <a
                            href="{{ route(
                            'my-smart-buy.payment',
                            $smartBuy
                        ) }}"
                            class="smart-buy-btn smart-buy-btn--primary"
                        >

                            Make Payment

                        </a>

                    </div>

                @endif



                {{-- ====================================================
                    Shipment
                ==================================================== --}}

                @if($smartBuy->shipment)

                    @php

                        $shipment = $smartBuy->shipment;

                        $shipmentStatus = ucfirst(
                            str_replace(
                                '_',
                                ' ',
                                $shipment->status
                            )
                        );

                    @endphp


                    <div class="smart-buy-details-card smart-buy-shipment-card">


                        {{-- Header --}}

                        <div class="smart-buy-details-card__header">

                            <div>

                                <span class="smart-buy-details-card__eyebrow">
                                    Delivery
                                </span>

                                <h3>
                                    Shipment Tracking
                                </h3>

                            </div>


                            <span class="
                                    smart-buy-shipment-status
                                    smart-buy-shipment-status--{{ $shipment->status }}
                            ">
                                {{ $shipmentStatus }}

                            </span>

                        </div>


                        {{-- Shipment Information --}}

                        <div class="smart-buy-shipment-section">

                            <h4 class="smart-buy-shipment-section__title">
                                Shipment Information
                            </h4>


                            <div class="smart-buy-shipment-info">


                                {{-- Shipment Number --}}

                                <div class="smart-buy-shipment-info__item">

                                    <span>
                                        Shipment Number
                                    </span>

                                    <strong>
                                        {{ $shipment->shipment_number ?? '—' }}
                                    </strong>

                                </div>


                                {{-- Shipment Status --}}

                                <div class="smart-buy-shipment-info__item">

                                    <span>
                                        Shipment Status
                                    </span>

                                    <strong>
                                        {{ $shipmentStatus }}
                                    </strong>

                                </div>


                                {{-- Carrier --}}

                                <div class="smart-buy-shipment-info__item">

                                    <span>
                                        Carrier
                                    </span>

                                    <strong>
                                        {{ $shipment->carrier ?? '—' }}
                                    </strong>

                                </div>


                                {{-- Shipping Method --}}

                                <div class="smart-buy-shipment-info__item">

                                    <span>
                                        Shipping Method
                                    </span>

                                    <strong>
                                        {{ $shipment->shipping_method ?? '—' }}
                                    </strong>

                                </div>

                            </div>

                        </div>


                        {{-- Shipping Timeline --}}

                        <div class="smart-buy-shipment-section">

                            <h4 class="smart-buy-shipment-section__title">
                                Shipping Timeline
                            </h4>


                            <div class="smart-buy-shipment-info">


                                {{-- Shipped Date --}}

                                <div class="smart-buy-shipment-info__item">

                                    <span>
                                        Shipped Date
                                    </span>

                                    <strong>

                                        {{
                                            $shipment->shipped_at
                                                ? $shipment->shipped_at->format('d M Y')
                                                : '—'
                                        }}

                                    </strong>

                                </div>


                                {{-- Estimated Delivery --}}

                                <div class="smart-buy-shipment-info__item">

                                    <span>
                                        Estimated Delivery
                                    </span>

                                    <strong>

                                        {{
                                            $shipment->estimated_delivery_at
                                                ? $shipment->estimated_delivery_at->format('d M Y')
                                                : '—'
                                        }}

                                    </strong>

                                </div>


                                {{-- Delivered Date --}}

                                <div class="smart-buy-shipment-info__item">

                                    <span>
                                        Delivered Date
                                    </span>

                                    <strong>

                                        {{
                                            $shipment->delivered_at
                                                ? $shipment->delivered_at->format('d M Y')
                                                : '—'
                                        }}

                                    </strong>

                                </div>
                            </div>

                        </div>


                        {{-- Delivery Address --}}

                        <div class="smart-buy-shipment-section">

                            <h4 class="smart-buy-shipment-section__title">
                                Delivery Address
                            </h4>


                            <div class="smart-buy-delivery-address">

                                <div class="smart-buy-delivery-address__icon">

                                    <i class="fa-solid fa-location-dot"></i>

                                </div>


                                <div class="smart-buy-delivery-address__content">

                                    <strong>

                                        {{ $smartBuy->first_name }}
                                        {{ $smartBuy->last_name }}

                                    </strong>


                                    <p>
                                        {{ $smartBuy->delivery_address }}
                                    </p>


                                    <p>

                                        {{ $smartBuy->city }}

                                        @if($smartBuy->zip_code)

                                            , {{ $smartBuy->zip_code }}

                                        @endif

                                    </p>


                                    <p>
                                        {{ $countryName }}
                                    </p>


                                    @if($smartBuy->phone)

                                        <p class="smart-buy-delivery-address__phone">

                                            <i class="fa-solid fa-phone"></i>

                                            {{ $smartBuy->phone }}

                                        </p>

                                    @endif

                                </div>

                            </div>

                        </div>


                        {{-- Shipment Notes --}}

                        @if($shipment->notes)

                            <div class="smart-buy-shipment-notes">

                                <div class="smart-buy-shipment-notes__icon">

                                    <i class="fa-solid fa-note-sticky"></i>

                                </div>


                                <div>

                                    <strong>
                                        Shipment Notes
                                    </strong>

                                    <p>
                                        {{ $shipment->notes }}
                                    </p>

                                </div>

                            </div>

                        @endif



                        {{-- Actions --}}

                        @if(
                            $shipment->tracking_url
                            || $shipment->tracking_number
                        )

                            <div class="smart-buy-details-card__actions">

                                <a
                                    href="{{ route('my-smart-buy.tracking', $smartBuy) }}"
                                    class="smart-buy-btn smart-buy-btn--primary">

                                    <i class="fa-solid fa-location-dot"></i>

                                    Track Shipment
                                </a>
                            </div>

                        @endif


                    </div>

                @endif

            </div>


            {{-- ========================================================
                Sidebar
            ======================================================== --}}

            <aside class="smart-buy-details__sidebar">


                {{-- ====================================================
                    Customer Information
                ==================================================== --}}

                <div class="smart-buy-sidebar-card">

                    <div class="smart-buy-sidebar-card__header">

                        <i class="fa-solid fa-user"></i>

                        <h3>
                            Delivery Information
                        </h3>

                    </div>


                    <div class="smart-buy-customer-info">

                        <div>

                        <span>
                            Name
                        </span>

                            <strong>

                                {{ $smartBuy->first_name }}
                                {{ $smartBuy->last_name }}

                            </strong>

                        </div>


                        <div>

                        <span>
                            Phone
                        </span>

                            <strong>
                                {{ $smartBuy->phone }}
                            </strong>

                        </div>


                        <div>

                        <span>
                            Email
                        </span>

                            <strong>
                                {{ $smartBuy->email }}
                            </strong>

                        </div>


                        <div>

                        <span>
                            Address
                        </span>

                            <strong>

                                {{ $smartBuy->delivery_address }}

                                @if($smartBuy->zip_code)

                                    <br>

                                    {{ $smartBuy->zip_code }}

                                @endif

                                <br>

                                {{ $smartBuy->city }}

                                <br>

                                {{ $countryName }}

                            </strong>

                        </div>

                    </div>

                </div>


                {{-- ====================================================
                    Request Timeline
                ==================================================== --}}

                <div class="smart-buy-sidebar-card">

                    <div class="smart-buy-sidebar-card__header">

                        <i class="fa-solid fa-clock-rotate-left"></i>

                        <h3>
                            Request Timeline
                        </h3>

                    </div>


                    <div class="smart-buy-timeline">


                        <div class="smart-buy-timeline__item is-active">

                            <div class="smart-buy-timeline__marker">

                                <i class="fa-solid fa-check"></i>

                            </div>


                            <div>

                                <strong>
                                    Request Submitted
                                </strong>

                                <span>
                                {{ $smartBuy->created_at->format('d M Y, h:i A') }}
                            </span>

                            </div>

                        </div>


                        @if($smartBuy->quote)

                            <div class="smart-buy-timeline__item is-active">

                                <div class="smart-buy-timeline__marker">

                                    <i class="fa-solid fa-check"></i>

                                </div>


                                <div>

                                    <strong>
                                        Quote Created
                                    </strong>

                                    <span>
                                    {{ $smartBuy->quote->created_at->format('d M Y, h:i A') }}
                                </span>

                                </div>

                            </div>

                        @endif


                        @if($smartBuy->payment?->paid_at)

                            <div class="smart-buy-timeline__item is-active">

                                <div class="smart-buy-timeline__marker">

                                    <i class="fa-solid fa-check"></i>

                                </div>


                                <div>

                                    <strong>
                                        Payment Completed
                                    </strong>

                                    <span>

                                    {{ $smartBuy->payment->paid_at->format('d M Y, h:i A') }}

                                </span>

                                </div>

                            </div>

                        @endif


                        @if($smartBuy->shipment?->shipped_at)

                            <div class="smart-buy-timeline__item is-active">

                                <div class="smart-buy-timeline__marker">

                                    <i class="fa-solid fa-check"></i>

                                </div>


                                <div>

                                    <strong>
                                        Shipment Created
                                    </strong>

                                    <span>

                                    {{ $smartBuy->shipment->shipped_at->format('d M Y, h:i A') }}

                                </span>

                                </div>

                            </div>

                        @endif


                        @if($smartBuy->shipment?->delivered_at)

                            <div class="smart-buy-timeline__item is-active">

                                <div class="smart-buy-timeline__marker">

                                    <i class="fa-solid fa-check"></i>

                                </div>


                                <div>

                                    <strong>
                                        Delivered
                                    </strong>

                                    <span>

                                    {{ $smartBuy->shipment->delivered_at->format('d M Y, h:i A') }}

                                </span>

                                </div>

                            </div>

                        @endif

                    </div>

                </div>


                {{-- Cancelled Notice --}}

                @if(
                    in_array(
                        $smartBuy->status,
                        ['cancelled', 'quote_rejected']
                    )
                )

                    <div class="smart-buy-cancelled-notice">

                        <i class="fa-solid fa-circle-xmark"></i>

                        <div>

                            <strong>
                                Request Cancelled
                            </strong>

                            <p>
                                This Smart Buy request is no longer active.
                            </p>

                        </div>

                    </div>

                @endif

            </aside>

        </div>

    </div>

@endsection
