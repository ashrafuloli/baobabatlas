@extends('backend.layouts.backend')

@section('title', 'Track Your Smart Buy')

@section('content')

    <div class="global-tracking">

        {{-- ==========================================================
        | Hero
        =========================================================== --}}

        <section class="tracking-hero">

            <div class="container">

                <div class="tracking-hero__content">

                    <div class="tracking-icon">

                        <i class="fa-solid fa-truck"></i>

                    </div>

                    <div class="tracking-hero__text">

                        <span class="tracking-eyebrow">
                            SMART BUY TRACKING
                        </span>

                        <h1>
                            Track Your Smart Buy
                        </h1>

                        <p>
                            Enter your Smart Buy number to check your current shipment status.
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
                            Enter your Smart Buy number, for example:
                            <strong>SB-000001</strong>
                        </p>

                    </div>


                    {{-- Error Message --}}

                    @if(session('error'))

                        <div class="tracking-alert tracking-alert--error">

                            <i class="fa-solid fa-circle-exclamation"></i>

                            <span>
                                {{ session('error') }}
                            </span>

                        </div>

                    @endif


                    {{-- Success Message --}}

                    @if(session('success'))

                        <div class="tracking-alert tracking-alert--success">

                            <i class="fa-solid fa-circle-check"></i>

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

                                <i class="fa-solid fa-magnifying-glass"></i>

                                <input
                                    type="text"
                                    name="request_number"
                                    id="requestNumber"
                                    value="{{ old('request_number') }}"
                                    placeholder="Enter Smart Buy Number (SB-000001)"
                                    autocomplete="off"
                                    maxlength="50"
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

                                <i class="fa-solid fa-arrow-right button-icon"></i>

                            </button>

                        </div>


                        @error('request_number')

                        <div class="tracking-validation-error">

                            <i class="fa-solid fa-circle-exclamation"></i>

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
        | Tracking Result
        =========================================================== --}}

        @if(isset($smartBuy) && isset($shipment) && $smartBuy && $shipment)

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
                            'fa-clock',
                    ],

                    [
                        'status' =>
                            \App\Models\SmartBuyShipment::STATUS_PREPARING,

                        'title' =>
                            'Preparing Shipment',

                        'description' =>
                            'Your order is being prepared for dispatch.',

                        'icon' =>
                            'fa-box',
                    ],

                    [
                        'status' =>
                            \App\Models\SmartBuyShipment::STATUS_SHIPPED,

                        'title' =>
                            'Shipped',

                        'description' =>
                            'Your shipment has been handed over to the carrier.',

                        'icon' =>
                            'fa-truck',
                    ],

                    [
                        'status' =>
                            \App\Models\SmartBuyShipment::STATUS_IN_TRANSIT,

                        'title' =>
                            'In Transit',

                        'description' =>
                            'Your shipment is currently on the way.',

                        'icon' =>
                            'fa-truck-fast',
                    ],

                    [
                        'status' =>
                            \App\Models\SmartBuyShipment::STATUS_OUT_FOR_DELIVERY,

                        'title' =>
                            'Out for Delivery',

                        'description' =>
                            'Your shipment is out for delivery.',

                        'icon' =>
                            'fa-location-dot',
                    ],

                    [
                        'status' =>
                            \App\Models\SmartBuyShipment::STATUS_DELIVERED,

                        'title' =>
                            'Delivered',

                        'description' =>
                            'Your shipment has been successfully delivered.',

                        'icon' =>
                            'fa-circle-check',
                    ],

                ];


                $currentStep = collect($shipmentSteps)
                    ->search(
                        fn ($step) =>
                            $step['status'] === $shipment->status
                    );


                $isCancelled =
                    $shipment->status
                    ===
                    \App\Models\SmartBuyShipment::STATUS_CANCELLED;


                if ($currentStep === false) {

                    $currentStep = 0;

                }


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

                    @if(!$isCancelled)

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


                                <div class="tracking-progress-percentage">

                                    {{ round($progressPercentage) }}%

                                </div>

                            </div>


                            <div class="shipment-progress-wrapper">


                                {{-- Progress Line --}}

                                <div class="shipment-progress-line">

                                    <div
                                        class="shipment-progress-line__active"
                                        style="width: {{ $progressPercentage }}%"
                                    ></div>

                                </div>


                                {{-- Shipment Steps --}}

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
                                                    class="
                                                        fa-solid
                                                        {{ $step['icon'] }}
                                                    "
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

                        </div>

                    @else

                        <div class="tracking-cancelled-message">

                            <div class="tracking-cancelled-message__icon">

                                <i class="fa-solid fa-circle-xmark"></i>

                            </div>

                            <div>

                                <h3>
                                    Shipment Cancelled
                                </h3>

                                <p>
                                    This shipment has been cancelled. Please contact support if you need further assistance.
                                </p>

                            </div>

                        </div>

                    @endif


                    {{-- ==================================================
                    | Shipment Details
                    ================================================== --}}

                    <div class="tracking-details-grid">


                        {{-- Shipment Information --}}

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
                    | Shipment Notes
                    ================================================== --}}

                    @if($shipment->notes)

                        <div class="tracking-notes">

                            <h3>

                                <i class="fa-solid fa-circle-info"></i>

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
                        '#requestNumber'
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
                | Format Smart Buy Number
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
                        | Keep SB Prefix
                        |--------------------------------------------------------------------------
                        */

                        if (
                            value.length > 0
                            &&
                            !value.startsWith('SB')
                        ) {

                            value =
                                value.replace(
                                    /[^A-Z0-9-]/g,
                                    ''
                                );

                        }


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

                        const requestNumber =
                            input?.value.trim();


                        if (!requestNumber) {

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

                                behavior:
                                    'smooth',

                                block:
                                    'start',

                            });

                        },
                        200
                    );

                }

            }
        );

    </script>

@endpush
