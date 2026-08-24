@extends('backend.layouts.backend')

@section('title', 'Quote Details')

@section('content')

    @php

        $currency = $quote->currency ?? 'USD';

        $status = $quote->status ?? 'pending';

        $statusLabel = match($status) {

            'pending' => 'Pending',
            'sent' => 'Quote Sent',
            'accepted' => 'Accepted',
            'rejected' => 'Rejected',
            'expired' => 'Expired',
            'cancelled' => 'Cancelled',

            default => ucfirst(
                str_replace(
                    '_',
                    ' ',
                    $status
                )
            ),

        };

        $statusClass = match($status) {

            'accepted' => 'status-accepted',
            'rejected' => 'status-rejected',
            'sent' => 'status-sent',
            'expired' => 'status-expired',
            'cancelled' => 'status-cancelled',

            default => 'status-pending',

        };

        $statusIcon = match($status) {

            'accepted' => 'ri-checkbox-circle-line',
            'rejected' => 'ri-close-circle-line',
            'sent' => 'ri-send-plane-line',
            'expired' => 'ri-time-line',
            'cancelled' => 'ri-forbid-2-line',

            default => 'ri-time-line',

        };

    @endphp


    <div class="smart-buy-quote-show-page">

        {{-- =========================================================
            Page Header
        ========================================================= --}}

        <div class="quote-page-header">

            <a
                href="{{ route('smart-buy.details', $quote->smartBuyRequest->id) }}"
                class="quote-back-link"
            >
                <i class="ri-arrow-left-line"></i>

                <span>
                Back to Smart Buy
            </span>
            </a>


            <div class="quote-page-header__content">

                <div class="quote-page-header__left">

                    <div class="quote-page-header__icon">

                        <i class="ri-file-list-3-line"></i>

                    </div>


                    <div class="quote-page-header__title">

                        <h1>
                            Quote Details
                        </h1>

                        <p>

                            {{ $quote->quote_number }}

                            <span>•</span>

                            Smart Buy:
                            {{ $quote->request_number }}

                        </p>

                    </div>

                </div>


                <div class="quote-page-header__actions">

                    @if(
                        in_array(
                            $quote->status,
                            [
                                'pending',
                                'rejected',
                                'sent'
                            ]
                        )
                    )

                        <a
                            href="{{ route('smart-buy.quote.edit', $quote->id) }}"
                            class="quote-edit-btn"
                        >
                            <i class="ri-edit-line"></i>

                            <span>
                            Edit Quote
                        </span>
                        </a>

                    @endif

                </div>

            </div>

        </div>



        {{-- =========================================================
            Quote Overview
        ========================================================= --}}

        <div class="quote-overview-grid">


            {{-- Quote Information --}}

            <div class="quote-overview-card">

                <div class="quote-overview-card__top">

                    <div>

                    <span class="quote-overview-card__label">

                        Quote Status

                    </span>

                        <h2>

                            {{ $statusLabel }}

                        </h2>

                    </div>


                    <div
                        class="quote-status-badge {{ $statusClass }}"
                    >

                        <i class="{{ $statusIcon }}"></i>

                        <span>
                        {{ $statusLabel }}
                    </span>

                    </div>

                </div>


                <div class="quote-overview-card__meta">


                    <div class="quote-meta-item">

                    <span>
                        Created
                    </span>

                        <strong>

                            {{ optional($quote->created_at)->format('d M Y, h:i A') }}

                        </strong>

                    </div>


                    <div class="quote-meta-item">

                    <span>
                        Valid Until
                    </span>

                        <strong>

                            @if($quote->expires_at)

                                {{ $quote->expires_at->format('d M Y') }}

                            @else

                                Not specified

                            @endif

                        </strong>

                    </div>


                    <div class="quote-meta-item">

                    <span>
                        Approved At
                    </span>

                        <strong>

                            @if($quote->approved_at)

                                {{ $quote->approved_at->format('d M Y, h:i A') }}

                            @else

                                —

                            @endif

                        </strong>

                    </div>


                </div>

            </div>



            {{-- Total Quote Amount --}}

            <div class="quote-total-card">

            <span class="quote-total-card__label">

                Total Quote Amount

            </span>


                <div class="quote-total-card__amount">

                    {{ number_format($quote->total_amount ?? 0, 2) }}

                    <small>

                        {{ $currency }}

                    </small>

                </div>


                <div class="quote-total-card__footer">

                <span>

                    {{ $quote->quoteItems->count() }}
                    {{ Str::plural('Product', $quote->quoteItems->count()) }}

                </span>


                    <i class="ri-shopping-bag-3-line"></i>

                </div>

            </div>


        </div>



        {{-- =========================================================
            Main Content
        ========================================================= --}}

        <div class="quote-main-grid">


            {{-- =====================================================
                Left Content
            ===================================================== --}}

            <div class="quote-main-content">


                {{-- Products & Pricing --}}

                <div class="quote-section-card">

                    <div class="quote-section-card__header">

                        <div>

                        <span class="quote-section-card__eyebrow">

                            Requested Products

                        </span>

                            <h2>

                                Products & Pricing

                            </h2>

                        </div>

                    </div>


                    <div class="quote-products-list">


                        @forelse($quote->quoteItems as $quoteItem)

                            @php

                                $requestItem =
                                    $quoteItem->smartBuyItem;

                                $productName =
                                    $requestItem->product_name
                                    ?? $requestItem->name
                                    ?? $requestItem->title
                                    ?? 'Requested Product';

                                $quantity =
                                    $quoteItem->quantity
                                    ?? $requestItem->quantity
                                    ?? 1;

                                $unitPrice =
                                    $quoteItem->unit_price
                                    ?? 0;

                                $itemTotal =
                                    $quoteItem->total_amount
                                    ?? (
                                        $unitPrice
                                        * $quantity
                                    );

                                $productImage =
                                    $requestItem->product_image
                                    ?? null;

                                $color =
                                    $requestItem->color
                                    ?? null;

                                $size =
                                    $requestItem->size
                                    ?? null;

                            @endphp


                            <div class="quote-product-item">


                                {{-- Product Image --}}

                                <div class="quote-product-item__image">

                                    @if($productImage)

                                        <img
                                            src="{{ asset($productImage) }}"
                                            alt="{{ $productName }}"
                                        >

                                    @else

                                        <i class="ri-image-line"></i>

                                    @endif

                                </div>



                                {{-- Product Details --}}

                                <div class="quote-product-item__content">

                                    <h3>

                                        {{ $productName }}

                                    </h3>


                                    <div class="quote-product-item__attributes">


                                        @if($color)

                                            <span>

                                            <i class="ri-palette-line"></i>

                                            Color:
                                            {{ $color }}

                                        </span>

                                        @endif


                                        @if($size)

                                            <span>

                                            <i class="ri-ruler-line"></i>

                                            Size:
                                            {{ $size }}

                                        </span>

                                        @endif


                                    </div>


                                    <div class="quote-product-item__pricing">

                                        {{ number_format($unitPrice, 2) }}
                                        {{ $currency }}

                                        <span>

                                        ×

                                    </span>

                                        {{ $quantity }}

                                    </div>


                                    @if($quoteItem->notes)

                                        <div class="quote-product-item__note">

                                            <i class="ri-file-text-line"></i>

                                            <span>

                                            {{ $quoteItem->notes }}

                                        </span>

                                        </div>

                                    @endif

                                </div>



                                {{-- Item Total --}}

                                <div class="quote-product-item__total">

                                <span>

                                    Item Total

                                </span>

                                    <strong>

                                        {{ number_format($itemTotal, 2) }}
                                        {{ $currency }}

                                    </strong>

                                </div>


                            </div>

                        @empty

                            <div class="quote-empty-state">

                                <div class="quote-empty-state__icon">

                                    <i class="ri-shopping-bag-line"></i>

                                </div>

                                <h3>

                                    No products found

                                </h3>

                                <p>

                                    No products have been added to this quote.

                                </p>

                            </div>

                        @endforelse


                    </div>

                </div>



                {{-- Quote Notes --}}

                <div class="quote-section-card">

                    <div class="quote-section-card__header">

                        <div>

                        <span class="quote-section-card__eyebrow">

                            Additional Information

                        </span>

                            <h2>

                                Quote Notes

                            </h2>

                        </div>

                    </div>


                    <div class="quote-notes-content">

                        <div class="quote-notes-content__icon">

                            <i class="ri-sticky-note-line"></i>

                        </div>


                        <div>

                            @if($quote->notes)

                                <p>

                                    {{ $quote->notes }}

                                </p>

                            @else

                                <p class="quote-notes-content__empty">

                                    No additional notes were added to this quote.

                                </p>

                            @endif

                        </div>

                    </div>

                </div>


            </div>



            {{-- =====================================================
                Sidebar
            ===================================================== --}}

            <aside class="quote-sidebar">


                {{-- Customer Details --}}

                <div class="quote-sidebar-card">

                    <div class="quote-sidebar-card__header">

                    <span>

                        Customer

                    </span>

                        <h2>

                            Customer Details

                        </h2>

                    </div>


                    <div class="quote-customer">


                        <div class="quote-customer__profile">

                            <div class="quote-customer__avatar">

                                {{ strtoupper(
                                    substr(
                                        $quote->first_name ?? 'C',
                                        0,
                                        1
                                    )
                                ) }}

                            </div>


                            <div>

                                <h3>

                                    {{ trim(
                                        ($quote->first_name ?? '')
                                        . ' '
                                        . ($quote->last_name ?? '')
                                    ) }}

                                </h3>

                                <p>

                                    {{ $quote->email ?? 'Not available' }}

                                </p>

                            </div>

                        </div>


                        <div class="quote-customer__info">


                            @if($quote->phone)

                                <div>

                                    <i class="ri-phone-line"></i>

                                    <span>

                                    {{ $quote->phone }}

                                </span>

                                </div>

                            @endif


                            @if(
                                $quote->delivery_address
                                || $quote->city
                                || $quote->country
                            )

                                <div>

                                    <i class="ri-map-pin-line"></i>

                                    <span>

                                    {{ collect([

                                        $quote->delivery_address,
                                        $quote->city,
                                        $quote->zip_code,
                                        $quote->country,

                                    ])
                                    ->filter()
                                    ->implode(', ') }}

                                </span>

                                </div>

                            @endif


                        </div>

                    </div>

                </div>



                {{-- Quote Summary --}}

                <div class="quote-sidebar-card">

                    <div class="quote-sidebar-card__header">

                    <span>

                        Pricing

                    </span>

                        <h2>

                            Quote Summary

                        </h2>

                    </div>


                    <div class="quote-summary">


                        <div class="quote-summary__row">

                        <span>

                            Product Total

                        </span>

                            <strong>

                                {{ number_format(
                                    $quote->product_total ?? 0,
                                    2
                                ) }}
                                {{ $currency }}

                            </strong>

                        </div>


                        <div class="quote-summary__row">

                        <span>

                            Service Fee

                        </span>

                            <strong>

                                {{ number_format(
                                    $quote->service_fee ?? 0,
                                    2
                                ) }}
                                {{ $currency }}

                            </strong>

                        </div>


                        <div class="quote-summary__row">

                        <span>

                            Shipping Fee

                        </span>

                            <strong>

                                {{ number_format(
                                    $quote->shipping_fee ?? 0,
                                    2
                                ) }}
                                {{ $currency }}

                            </strong>

                        </div>


                        @if(($quote->discount ?? 0) > 0)

                            <div class="quote-summary__row quote-summary__discount">

                            <span>

                                Discount

                            </span>

                                <strong>

                                    -
                                    {{ number_format(
                                        $quote->discount,
                                        2
                                    ) }}
                                    {{ $currency }}

                                </strong>

                            </div>

                        @endif


                        <div class="quote-summary__total">

                        <span>

                            Total Amount

                        </span>

                            <strong>

                                {{ number_format(
                                    $quote->total_amount ?? 0,
                                    2
                                ) }}
                                {{ $currency }}

                            </strong>

                        </div>


                    </div>

                </div>



                {{-- Smart Buy Request --}}

                <div class="quote-sidebar-card">

                    <div class="quote-sidebar-card__header">

                    <span>

                        Request

                    </span>

                        <h2>

                            Smart Buy Request

                        </h2>

                    </div>


                    <div class="quote-request-info">


                        <div class="quote-request-info__item">

                        <span>

                            Request Number

                        </span>

                            <strong>

                                {{ $quote->request_number }}

                            </strong>

                        </div>


                        <div class="quote-request-info__item">

                        <span>

                            Request Status

                        </span>

                            <strong>

                                {{ ucfirst(
                                    str_replace(
                                        '_',
                                        ' ',
                                        $quote->status
                                    )
                                ) }}

                            </strong>

                        </div>


                        <div class="quote-request-info__item">

                        <span>

                            Submitted

                        </span>

                            <strong>

                                {{ optional(
                                    $quote->created_at
                                )->format('d M Y') }}

                            </strong>

                        </div>


                    </div>


                    <div class="quote-request-info__footer">

                        <a
                            href="{{ route('smart-buy.details', $quote->smartBuyRequest->id) }}"
                        >

                        <span>

                            View Smart Buy Request

                        </span>

                            <i class="ri-arrow-right-line"></i>

                        </a>

                    </div>

                </div>


            </aside>


        </div>


    </div>

@endsection
