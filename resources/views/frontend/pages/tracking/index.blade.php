@extends('frontend.layouts.frontend')

@section('contents')

    <div class="tracking-page">

        {{-- ==========================================================
        | Hero
        ========================================================== --}}

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
        ========================================================== --}}

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


                        {{-- Error Message --}}

                        @if(session('error'))

                            <div class="tracking-alert">

                                <i class="ri-error-warning-line"></i>

                                <span>
                                    {{ session('error') }}
                                </span>

                            </div>

                        @endif


                        {{-- Tracking Form --}}

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
                                    name="request_number"
                                    id="requestNumber"
                                    value="{{ old('request_number', $smartBuy?->request_number) }}"
                                    placeholder="Enter your Smart Buy number"
                                    autocomplete="off"
                                >

                                @if($smartBuy && $shipment)

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


                        @error('request_number')

                        <div class="tracking-validation-error">

                            {{ $message }}

                        </div>

                        @enderror


                        {{-- Search Again / Reset --}}

                        @if($smartBuy && $shipment)

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
                                src="{{ asset('assets/img/thumb/thumb-3.png') }}"
                                alt="Shipment Tracking"
                            >

                        </div>

                    </div>

                </div>

            </div>

        </section>


        {{-- ==========================================================
        | Tracking Result
        ========================================================== --}}

        @if($smartBuy && $shipment)

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


                $currentStep = collect($shipmentSteps)
                    ->search(
                        fn ($step) =>
                            $step['status'] === $shipment->status
                    );


                if ($currentStep === false) {

                    $currentStep = 0;

                }


                $progressPercentage =
                    count($shipmentSteps) > 1
                        ? ($currentStep / (count($shipmentSteps) - 1)) * 100
                        : 0;

            @endphp


            <section
                class="tracking-result-section"
                id="trackingResult"
            >

                <div class="container">


                    {{-- Result Header --}}

                    <div class="tracking-result-header">

                        <div>

                            <span class="subtitle">
                                SHIPMENT STATUS
                            </span>

                            <h2>
                                Your Shipment Progress
                            </h2>

                        </div>


                        <div class="tracking-result-header__actions">

                            <div class="tracking-status-badge">

                                {{ $shipmentSteps[$currentStep]['title'] }}

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


                    {{-- Tracking Numbers --}}

                    <div class="tracking-number-card">


                        <div class="tracking-number-card__item">

                            <span>
                                Smart Buy Number
                            </span>

                            <strong>
                                {{ $smartBuy->request_number }}
                            </strong>

                        </div>


                        @if($shipment->shipment_number)

                            <div class="tracking-number-card__item">

                                <span>
                                    Shipment Number
                                </span>

                                <strong>
                                    {{ $shipment->shipment_number }}
                                </strong>

                            </div>

                        @endif


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

                    </div>


                    {{-- ======================================================
                    | Progress
                    ====================================================== --}}

                    <div class="tracking-progress">


                        <div class="tracking-progress__top">

                            <span>
                                Shipment Progress
                            </span>

                            <strong>
                                {{ round($progressPercentage) }}%
                            </strong>

                        </div>


                        <div class="tracking-progress__line">

                            <div
                                class="tracking-progress__active"
                                style="width: {{ $progressPercentage }}%"
                            ></div>

                        </div>


                        <div class="tracking-progress__steps">

                            @foreach($shipmentSteps as $index => $step)

                                @php

                                    $isCompleted =
                                        $index < $currentStep;

                                    $isCurrent =
                                        $index === $currentStep;

                                @endphp


                                <div
                                    class="tracking-step
                                    {{ $isCompleted ? 'is-completed' : '' }}
                                    {{ $isCurrent ? 'is-current' : '' }}"
                                >

                                    <div class="tracking-step__icon">

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


                    {{-- ======================================================
                    | Shipment Details
                    ====================================================== --}}

                    <div class="tracking-details-grid">

                        {{-- Shipment Information --}}

                        <div class="tracking-details-card">

                            <h3>
                                Shipment Information
                            </h3>


                            {{-- Shipment Number --}}

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


                            {{-- Carrier --}}

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


                            {{-- Shipping Method --}}

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


                            {{-- Shipped Date --}}

                            @if($shipment->shipped_at)

                                <div class="tracking-detail-row">

                                    <span>
                                        Shipped Date
                                    </span>

                                    <strong>
                                        {{
                                            \Carbon\Carbon::parse(
                                                $shipment->shipped_at
                                            )->format('d M Y')
                                        }}
                                    </strong>

                                </div>

                            @endif


                            {{-- Estimated Delivery --}}

                            @if($shipment->estimated_delivery_at)

                                <div class="tracking-detail-row">

                <span>
                    Estimated Delivery
                </span>

                                    <strong>
                                        {{
                                            \Carbon\Carbon::parse(
                                                $shipment->estimated_delivery_at
                                            )->format('d M Y')
                                        }}
                                    </strong>

                                </div>

                            @endif


                            {{-- Delivered Date --}}

                            @if($shipment->delivered_at)

                                <div class="tracking-detail-row">

                <span>
                    Delivered Date
                </span>

                                    <strong>
                                        {{
                                            \Carbon\Carbon::parse(
                                                $shipment->delivered_at
                                            )->format('d M Y')
                                        }}
                                    </strong>

                                </div>

                            @endif

                        </div>

                    </div>


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


                    {{-- Bottom New Search --}}

                    <div class="tracking-bottom-actions">

                        <a
                            href="{{ route('tracking') }}"
                            class="tracking-new-search-btn"
                        >

                            <i class="ri-search-line"></i>

                            Track Another Shipment

                        </a>

                    </div>

                </div>

            </section>

        @endif


        {{-- ==========================================================
        | FAQ
        ========================================================== --}}

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
                                        How can I track my shipment?
                                    </span>

                                    <i class="ri-add-line"></i>

                                </button>


                                <div class="faq-answer">

                                    <div class="inner">

                                        <p>
                                            Enter your Smart Buy number in the
                                            tracking form to view your current
                                            shipment status.
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
                                        How long does shipping take?
                                    </span>

                                    <i class="ri-add-line"></i>

                                </button>


                                <div class="faq-answer">

                                    <div class="inner">

                                        <p>
                                            Shipping time depends on your
                                            destination and selected shipping
                                            method.
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
                                            Yes. Once your shipment has been
                                            processed, you can check its latest
                                            available status using your Smart
                                            Buy number.
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
        ========================================================== --}}

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

                                <a href="#">

                                    Request a Quote

                                    <i class="ri-arrow-right-line"></i>

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

                const trackingPage =
                    document.querySelector(
                        '.tracking-page'
                    );


                if (!trackingPage) {
                    return;
                }


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


                const resetInput =
                    trackingPage.querySelector(
                        '#resetInput'
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
                                    .replace(/\s/g, '');

                        }
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | Clear Input
                |--------------------------------------------------------------------------
                */

                if (resetInput && input) {

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

                if (form && input && button) {

                    form.addEventListener(
                        'submit',
                        function (event) {

                            if (!input.value.trim()) {

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

                const trackingResult =
                    trackingPage.querySelector(
                        '#trackingResult'
                    );


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
