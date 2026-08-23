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
                'label' => 'Pending Review',
                'class' => 'pending',
                'progress' => 10,
            ],

            'quote_sent' => [
                'label' => 'Quote Available',
                'class' => 'quote',
                'progress' => 30,
            ],

            'quote_accepted' => [
                'label' => 'Awaiting Payment',
                'class' => 'payment',
                'progress' => 50,
            ],

            'payment_completed' => [
                'label' => 'Payment Completed',
                'class' => 'payment-completed',
                'progress' => 65,
            ],

            'product_purchased' => [
                'label' => 'Product Purchased',
                'class' => 'purchased',
                'progress' => 75,
            ],

            'in_transit' => [
                'label' => 'In Transit',
                'class' => 'shipping',
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

            'quote_rejected' => [
                'label' => 'Quote Rejected',
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


    <div class="smart-buy-details">

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
            Request Progress
        ============================================================ --}}

        <div class="smart-buy-progress-card">

            <div class="smart-buy-progress-card__header">

                <div>

                    <h3>
                        Request Progress
                    </h3>

                    <p>
                        Track the current progress of your Smart Buy request.
                    </p>

                </div>


                <strong>
                    {{ $currentStatus['progress'] }}%
                </strong>

            </div>


            <div class="smart-buy-progress">

                <div class="smart-buy-progress__line">

                    <div
                        class="smart-buy-progress__active"
                        style="width: {{ $currentStatus['progress'] }}%"
                    ></div>

                </div>


                <div class="smart-buy-progress__steps">

                    <div
                        class="smart-buy-progress__step
                    {{ in_array($smartBuy->status, [
                        'pending',
                        'quote_sent',
                        'quote_accepted',
                        'payment_completed',
                        'product_purchased',
                        'in_transit',
                        'completed'
                    ]) ? 'is-active' : '' }}"
                    >

                    <span class="smart-buy-progress__circle">

                        <i class="fa-solid fa-file-lines"></i>

                    </span>

                        <span>
                        Request
                    </span>

                    </div>


                    <div
                        class="smart-buy-progress__step
                    {{ in_array($smartBuy->status, [
                        'quote_sent',
                        'quote_accepted',
                        'payment_completed',
                        'product_purchased',
                        'in_transit',
                        'completed'
                    ]) ? 'is-active' : '' }}"
                    >

                    <span class="smart-buy-progress__circle">

                        <i class="fa-solid fa-file-invoice-dollar"></i>

                    </span>

                        <span>
                        Quote
                    </span>

                    </div>


                    <div
                        class="smart-buy-progress__step
                    {{ in_array($smartBuy->status, [
                        'quote_accepted',
                        'payment_completed',
                        'product_purchased',
                        'in_transit',
                        'completed'
                    ]) ? 'is-active' : '' }}"
                    >

                    <span class="smart-buy-progress__circle">

                        <i class="fa-solid fa-credit-card"></i>

                    </span>

                        <span>
                        Payment
                    </span>

                    </div>


                    <div
                        class="smart-buy-progress__step
                    {{ in_array($smartBuy->status, [
                        'product_purchased',
                        'in_transit',
                        'completed'
                    ]) ? 'is-active' : '' }}"
                    >

                    <span class="smart-buy-progress__circle">

                        <i class="fa-solid fa-truck"></i>

                    </span>

                        <span>
                        Shipping
                    </span>

                    </div>


                    <div
                        class="smart-buy-progress__step
                    {{ $smartBuy->status === 'completed' ? 'is-active' : '' }}"
                    >

                    <span class="smart-buy-progress__circle">

                        <i class="fa-solid fa-circle-check"></i>

                    </span>

                        <span>
                        Completed
                    </span>

                    </div>

                </div>

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
                                            src="{{ asset('storage/' . $item->product_image) }}"
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
                                ['quote_sent']
                            )
                        )

                            <div class="smart-buy-details-card__actions">

                                <a
                                    href="{{ route(
                                    'my-smart-buy-quote',
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

                @elseif($smartBuy->status === 'quote_accepted')

                    <div class="smart-buy-payment-required">

                        <div class="smart-buy-payment-required__icon">

                            <i class="fa-solid fa-credit-card"></i>

                        </div>


                        <div class="smart-buy-payment-required__content">

                            <h3>
                                Payment Required
                            </h3>

                            <p>
                                Your quote has been accepted. Please proceed with payment to continue your Smart Buy request.
                            </p>

                        </div>


                        <a
                            href="{{ route(
                            'smart-buy-payment',
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

                    <div class="smart-buy-details-card">

                        <div class="smart-buy-details-card__header">

                            <div>

                            <span class="smart-buy-details-card__eyebrow">

                                Delivery

                            </span>

                                <h3>
                                    Shipment Tracking
                                </h3>

                            </div>


                            <span
                                class="smart-buy-shipment-status
                            smart-buy-shipment-status--{{ $smartBuy->shipment->status }}"
                            >

                            {{
                                ucfirst(
                                    str_replace(
                                        '_',
                                        ' ',
                                        $smartBuy->shipment->status
                                    )
                                )
                            }}

                        </span>

                        </div>


                        <div class="smart-buy-shipment-info">

                            <div class="smart-buy-shipment-info__item">

                            <span>
                                Carrier
                            </span>

                                <strong>

                                    {{
                                        $smartBuy->shipment->carrier
                                        ?? '—'
                                    }}

                                </strong>

                            </div>


                            <div class="smart-buy-shipment-info__item">

                            <span>
                                Tracking Number
                            </span>

                                <strong>

                                    {{
                                        $smartBuy->shipment->tracking_number
                                        ?? 'Not available yet'
                                    }}

                                </strong>

                            </div>


                            <div class="smart-buy-shipment-info__item">

                            <span>
                                Estimated Delivery
                            </span>

                                <strong>

                                    {{
                                        $smartBuy->shipment
                                            ->estimated_delivery_at
                                            ? $smartBuy->shipment
                                                ->estimated_delivery_at
                                                ->format('d M Y')
                                            : '—'
                                    }}

                                </strong>

                            </div>

                        </div>


                        <div class="smart-buy-details-card__actions">

                            <a
                                href="{{ route(
                                'smart-buy-tracking',
                                $smartBuy
                            ) }}"
                                class="smart-buy-btn smart-buy-btn--outline"
                            >

                                <i class="fa-solid fa-location-dot"></i>

                                Track Shipment

                            </a>


                            @if($smartBuy->shipment->tracking_url)

                                <a
                                    href="{{ $smartBuy->shipment->tracking_url }}"
                                    target="_blank"
                                    rel="noopener"
                                    class="smart-buy-btn smart-buy-btn--primary"
                                >

                                    Track with Carrier

                                    <i class="fa-solid fa-arrow-up-right-from-square"></i>

                                </a>

                            @endif

                        </div>

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
