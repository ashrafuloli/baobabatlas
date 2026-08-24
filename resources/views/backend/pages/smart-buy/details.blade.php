@extends('backend.layouts.backend')

@section('title', 'Smart Buy Details')

@section('content')

    @php

        $statusLabels = [
            'pending' => 'Pending',
            'quote_sent' => 'Quote Sent',
            'quote_accepted' => 'Quote Accepted',
            'quote_rejected' => 'Quote Rejected',
            'payment_pending' => 'Payment Pending',
            'payment_completed' => 'Payment Completed',
            'product_purchased' => 'Product Purchased',
            'in_transit' => 'In Transit',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
        ];

        $statusClasses = [
            'pending' => 'status-pending',
            'quote_sent' => 'status-info',
            'quote_accepted' => 'status-success',
            'quote_rejected' => 'status-danger',
            'payment_pending' => 'status-warning',
            'payment_completed' => 'status-success',
            'product_purchased' => 'status-info',
            'in_transit' => 'status-info',
            'completed' => 'status-success',
            'cancelled' => 'status-danger',
        ];

        $quote =
            $smartBuy->latestQuote
            ?? $smartBuy->quote;

        $hasQuote = !empty($quote);

    @endphp


    <div class="smart-buy-details-page">


        {{-- ============================================================
            PAGE HEADER
        ============================================================ --}}

        <div class="smart-buy-page-header">

            <div class="header-left">

                <a
                    href="{{ route('smart-buy') }}"
                    class="back-link"
                >
                    <i class="ri-arrow-left-line"></i>

                    <span>
                        Back to Smart Buy
                    </span>
                </a>


                <div class="request-title-row">

                    <div>

                        <span class="request-label">
                            Smart Buy Request
                        </span>

                        <h1>
                            {{ $smartBuy->request_number }}
                        </h1>

                    </div>


                    <span
                        class="status-badge {{ $statusClasses[$smartBuy->status] ?? 'status-pending' }}"
                    >
                        {{ $statusLabels[$smartBuy->status] ?? ucwords(str_replace('_', ' ', $smartBuy->status)) }}
                    </span>

                </div>

            </div>


            <div class="header-actions">

                @if(!$hasQuote)

                    <a
                        href="{{ route('smart-buy.quote.create' , $smartBuy->id ) }}"
                        class="btn btn-primary"
                    >
                        <i class="ri-file-add-line"></i>

                        <span>
                            Create Quote
                        </span>
                    </a>

                @else

                    <a
                        href="{{ route('smart-buy.quote.show' , $quote->id ) }}"
                        class="btn btn-secondary"
                    >
                        <i class="ri-eye-line"></i>

                        <span>
                            View Quote
                        </span>
                    </a>


                    @if(
                        $smartBuy->status !== 'quote_accepted'
                        &&
                        !$quote->isAccepted()
                    )
                        <a
                            href="{{ route('smart-buy.quote.edit', $quote->id) }}"
                            class="btn btn-primary"
                        >
                            <i class="ri-edit-line"></i>

                            Edit Quote
                        </a>

                    @endif

                @endif


                <button
                    type="button"
                    class="btn btn-outline"
                    onclick="document.getElementById('status-section').scrollIntoView({ behavior: 'smooth' })"
                >
                    <i class="ri-pencil-line"></i>

                    <span>
                        Update Status
                    </span>
                </button>

            </div>

        </div>


        {{-- ============================================================
            MAIN GRID
        ============================================================ --}}

        <div class="smart-buy-content-grid">


            {{-- ========================================================
                LEFT COLUMN
            ======================================================== --}}

            <div class="main-column">


                {{-- ====================================================
                    REQUESTED PRODUCTS
                ==================================================== --}}

                <div class="smart-buy-card">

                    <div class="card-header">

                        <div class="card-heading">

                            <div class="card-icon">
                                <i class="ri-shopping-bag-3-line"></i>
                            </div>

                            <div>

                                <h2>
                                    Requested Products
                                </h2>

                                <p>
                                    Products requested by the customer
                                </p>

                            </div>

                        </div>


                        <span class="item-count">

                            {{ $smartBuy->items->count() }}

                            {{ Str::plural('Item', $smartBuy->items->count()) }}

                        </span>

                    </div>


                    <div class="requested-products">

                        @forelse($smartBuy->items as $index => $item)

                            @php

                                $image =
                                    $item->product_image
                                    ?? null;

                            @endphp


                            <div class="requested-product">


                                <div class="product-main-row">


                                    {{-- Product Image / Number --}}

                                    <div class="product-image-wrap">

                                        @if($image)

                                            <img
                                                src="{{ asset($image) }}"
                                                alt="{{ $item->product_name ?? 'Product' }}"
                                                class="product-image"
                                            >

                                        @else

                                            <div class="product-number">

                                                {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}

                                            </div>

                                        @endif

                                    </div>


                                    {{-- Product Information --}}

                                    <div class="product-info">

                                        <div class="product-title-row">

                                            <h3>
                                                {{ $item->product_name ?? 'Product Request' }}
                                            </h3>


                                            <div class="product-quantity">

                                                <span>
                                                    Qty:
                                                </span>

                                                <strong>
                                                    {{ $item->quantity ?? 1 }}
                                                </strong>

                                            </div>

                                        </div>


                                        @if(!empty($item->product_url))

                                            <a
                                                href="{{ $item->product_url }}"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                class="view-product"
                                            >
                                                <i class="ri-external-link-line"></i>

                                                View Product
                                            </a>

                                        @endif



                                        {{-- Product Attributes --}}

                                        <div class="product-meta">

                                            <span class="product-meta-item">

                                                <span class="meta-label">
                                                    Qty:
                                                </span>

                                                <strong>
                                                    {{ $item->quantity ?? 1 }}
                                                </strong>

                                            </span>


                                            @if(!empty($item->size))

                                                <span class="product-meta-item">

                                                    <span class="meta-label">
                                                        Size:
                                                    </span>

                                                    <strong>
                                                        {{ $item->size }}
                                                    </strong>

                                                </span>

                                            @endif


                                            @if(!empty($item->color))

                                                <span class="product-meta-item">

                                                    <span class="meta-label">
                                                        Color:
                                                    </span>

                                                    <strong>
                                                        {{ $item->color }}
                                                    </strong>

                                                </span>

                                            @endif


                                            @if(!empty($item->variant))

                                                <span class="product-meta-item">

                                                    <span class="meta-label">
                                                        Variant:
                                                    </span>

                                                    <strong>
                                                        {{ $item->variant }}
                                                    </strong>

                                                </span>

                                            @endif

                                        </div>

                                    </div>

                                </div>


                                {{-- Product Notes --}}

                                @if(!empty($item->notes))

                                    <div class="product-notes">

                                        <strong>
                                            Notes:
                                        </strong>

                                        <span>
                                            {{ $item->notes }}
                                        </span>

                                    </div>

                                @endif


                            </div>

                        @empty

                            <div class="empty-state small-empty">

                                <div class="empty-icon">
                                    <i class="ri-inbox-line"></i>
                                </div>

                                <h3>
                                    No products found
                                </h3>

                                <p>
                                    No products have been added to this request.
                                </p>

                            </div>

                        @endforelse

                    </div>

                </div>


                {{-- ====================================================
                    QUOTE DETAILS
                ==================================================== --}}

                <div class="smart-buy-card">

                    <div class="card-header">

                        <div class="card-heading">

                            <div class="card-icon">
                                <i class="ri-file-list-3-line"></i>
                            </div>

                            <div>

                                <h2>
                                    Quote Details
                                </h2>

                                <p>
                                    Latest quote and pricing information
                                </p>

                            </div>

                        </div>


                        @if($quote)

                            <span
                                class="quote-status-badge {{ $statusClasses[$quote->status] ?? 'status-pending' }}"
                            >
                                {{ ucwords(str_replace('_', ' ', $quote->status ?? 'pending')) }}
                            </span>

                        @else

                            <span class="quote-status-badge pending">
                                No Quote
                            </span>

                        @endif

                    </div>


                    @if($quote)

                        {{-- Quote Summary --}}

                        <div class="quote-summary-grid">

                            <div class="quote-summary-item">

                                <span>
                                    Quote Number
                                </span>

                                <strong>
                                    {{ $quote->quote_number ?? ('#' . $quote->id) }}
                                </strong>

                            </div>


                            <div class="quote-summary-item">

                                <span>
                                    Total Amount
                                </span>

                                <strong class="quote-total">

                                    {{ $quote->currency ?? 'USD' }}

                                    {{ number_format(
                                        $quote->total_amount
                                        ?? $quote->amount
                                        ?? 0,
                                        2
                                    ) }}

                                </strong>

                            </div>


                            <div class="quote-summary-item">

                                <span>
                                    Created
                                </span>

                                <strong>

                                    {{ optional($quote->created_at)->format('M d, Y') ?? '—' }}

                                </strong>

                            </div>


                            <div class="quote-summary-item">

                                <span>
                                    Last Updated
                                </span>

                                <strong>

                                    {{ optional($quote->updated_at)->diffForHumans() ?? '—' }}

                                </strong>

                            </div>


                            <div class="quote-summary-item">

                                <span>
                                    Items
                                </span>

                                <strong>

                                    {{ optional($quote->quoteItems)->count() ?? 0 }}

                                    {{ Str::plural(
                                        'Item',
                                        optional($quote->quoteItems)->count() ?? 0
                                    ) }}

                                </strong>

                            </div>


                            <div class="quote-summary-item">

                                <span>
                                    Status
                                </span>

                                <strong>

                                    {{ ucwords(str_replace('_', ' ', $quote->status ?? 'pending')) }}

                                </strong>

                            </div>

                        </div>



                        {{-- Quote Items --}}

                        <div class="quote-items-box">

                            <div class="quote-items-header">

                                <div>
                                    <h3>
                                        Quote Items
                                    </h3>

                                    <p>
                                        Product pricing breakdown
                                    </p>
                                </div>

                            </div>


                            <div class="quote-items-table">


                                <div class="quote-table-head">

                                    <span>
                                        Product
                                    </span>

                                    <span>
                                        Quantity
                                    </span>

                                    <span>
                                        Unit Price
                                    </span>

                                    <span>
                                        Total
                                    </span>

                                </div>


                                @forelse($quote->quoteItems as $quoteItem)

                                    @php

                                        $product =
                                            $quoteItem->smartBuyItem;

                                        $quantity =
                                            $quoteItem->quantity ?? 1;

                                        $unitPrice =
                                            $quoteItem->unit_price
                                            ?? $quoteItem->price
                                            ?? 0;

                                        $lineTotal =
                                            $quoteItem->total_amount
                                            ?? $quoteItem->total
                                            ?? (
                                                $unitPrice * $quantity
                                            );

                                    @endphp


                                    <div class="quote-table-row">

                                        <div class="quote-product-name">

                                            <strong>

                                                {{ optional($product)->product_name
                                                    ?? optional($product)->name
                                                    ?? 'Product' }}

                                            </strong>

                                        </div>


                                        <div>

                                            {{ $quantity }}

                                        </div>


                                        <div>

                                            {{ $quote->currency ?? 'USD' }}

                                            {{ number_format($unitPrice, 2) }}

                                        </div>


                                        <div class="quote-line-total">

                                            {{ $quote->currency ?? 'USD' }}

                                            {{ number_format($lineTotal, 2) }}

                                        </div>

                                    </div>

                                @empty

                                    <div class="quote-table-empty">

                                        <i class="ri-file-search-line"></i>

                                        <span>
                                            No quote items found.
                                        </span>

                                    </div>

                                @endforelse

                            </div>

                        </div>



                        {{-- Quote Notes --}}

                        @if(!empty($quote->notes))

                            <div class="quote-notes">

                                <div class="quote-notes-icon">
                                    <i class="ri-sticky-note-line"></i>
                                </div>

                                <div>

                                    <strong>
                                        Quote Notes
                                    </strong>

                                    <p>
                                        {{ $quote->notes }}
                                    </p>

                                </div>

                            </div>

                        @endif



                        {{-- Quote Actions --}}

                        <div class="quote-action-bottom">

                            <a
                                href="{{ route('smart-buy.quote.show' , $quote->id ) }}"
                                class="btn btn-secondary"
                            >
                                <i class="ri-eye-line"></i>

                                View Full Quote
                            </a>


                            @if(
                                $smartBuy->status !== 'quote_accepted'
                                &&
                                !$quote->isAccepted()
                            )
                                <a
                                    href="{{ route('smart-buy.quote.edit', $quote->id) }}"
                                    class="btn btn-primary"
                                >
                                    <i class="ri-edit-line"></i>

                                    Edit Quote
                                </a>

                            @endif

                        </div>

                    @else

                        {{-- Empty Quote State --}}

                        <div class="quote-empty-state">

                            <div class="empty-icon">
                                <i class="ri-file-add-line"></i>
                            </div>

                            <h3>
                                No quote created yet
                            </h3>

                            <p>
                                Create a quote and add pricing for the requested products.
                            </p>

                            <a
                                href="{{ route('smart-buy.quote.create' , $smartBuy->id ) }}"
                                class="btn btn-primary"
                            >
                                <i class="ri-add-circle-line"></i>

                                Create Quote
                            </a>

                        </div>

                    @endif

                </div>


                {{-- ====================================================
                    PAYMENT DETAILS
                ==================================================== --}}

                <div class="smart-buy-card">

                    <div class="card-header">

                        <div class="card-heading">

                            <div class="card-icon">
                                <i class="ri-bank-card-line"></i>
                            </div>

                            <div>

                                <h2>
                                    Payment Details
                                </h2>

                                <p>
                                    Payment information for this request
                                </p>

                            </div>

                        </div>

                    </div>


                    @if($smartBuy->payment)

                        <div class="info-grid">

                            <div class="info-item">

                                <span>
                                    Amount
                                </span>

                                <strong>

                                    {{ $smartBuy->payment->currency ?? 'USD' }}

                                    {{ number_format(
                                        $smartBuy->payment->amount ?? 0,
                                        2
                                    ) }}

                                </strong>

                            </div>


                            <div class="info-item">

                                <span>
                                    Status
                                </span>

                                <strong>

                                    {{ ucfirst(
                                        str_replace(
                                            '_',
                                            ' ',
                                            $smartBuy->payment->status ?? '—'
                                        )
                                    ) }}

                                </strong>

                            </div>

                        </div>

                    @else

                        <div class="empty-state">

                            <div class="empty-icon">
                                <i class="ri-bank-card-line"></i>
                            </div>

                            <h3>
                                No payment recorded
                            </h3>

                            <p>
                                Payment information will appear here once added.
                            </p>

                        </div>

                    @endif

                </div>


                {{-- ====================================================
                    SHIPPING & TRACKING
                ==================================================== --}}

                <div class="smart-buy-card">

                    <div class="card-header">

                        <div class="card-heading">

                            <div class="card-icon">
                                <i class="ri-truck-line"></i>
                            </div>

                            <div>

                                <h2>
                                    Shipping & Tracking
                                </h2>

                                <p>
                                    Shipment and delivery information
                                </p>

                            </div>

                        </div>


                        @if($smartBuy->shipment)

                            @php

                                $shipmentStatusLabels = [

                                    'pending' => 'Pending',

                                    'preparing' => 'Preparing',

                                    'shipped' => 'Shipped',

                                    'in_transit' => 'In Transit',

                                    'out_for_delivery' => 'Out for Delivery',

                                    'delivered' => 'Delivered',

                                    'cancelled' => 'Cancelled',

                                ];

                                $shipmentStatusClasses = [

                                    'pending' => 'status-pending',

                                    'preparing' => 'status-warning',

                                    'shipped' => 'status-info',

                                    'in_transit' => 'status-info',

                                    'out_for_delivery' => 'status-warning',

                                    'delivered' => 'status-success',

                                    'cancelled' => 'status-danger',

                                ];

                            @endphp


                            <span
                                class="status-badge {{ $shipmentStatusClasses[$smartBuy->shipment->status] ?? 'status-pending' }}"
                            >

                {{
                    $shipmentStatusLabels[$smartBuy->shipment->status]
                    ?? ucwords(
                        str_replace(
                            '_',
                            ' ',
                            $smartBuy->shipment->status
                        )
                    )
                }}

            </span>

                        @endif

                    </div>


                    @if($smartBuy->shipment)

                        @php

                            $shipment = $smartBuy->shipment;

                        @endphp


                        {{-- ====================================================
                            SHIPMENT BASIC INFORMATION
                        ==================================================== --}}

                        <div class="shipping-section">

                            <div class="shipping-section-header">

                                <h3>
                                    Shipment Information
                                </h3>

                            </div>


                            <div class="info-grid">

                                {{-- Shipment Number --}}

                                <div class="info-item">

                    <span>
                        Shipment Number
                    </span>

                                    <strong>

                                        {{ $shipment->shipment_number ?? '—' }}

                                    </strong>

                                </div>


                                {{-- Status --}}

                                <div class="info-item">

                    <span>
                        Shipment Status
                    </span>

                                    <strong>

                                        {{
                                            $shipmentStatusLabels[$shipment->status]
                                            ?? ucwords(
                                                str_replace(
                                                    '_',
                                                    ' ',
                                                    $shipment->status ?? 'pending'
                                                )
                                            )
                                        }}

                                    </strong>

                                </div>


                                {{-- Carrier --}}

                                <div class="info-item">

                    <span>
                        Carrier
                    </span>

                                    <strong>

                                        {{ $shipment->carrier ?? '—' }}

                                    </strong>

                                </div>


                                {{-- Shipping Method --}}

                                <div class="info-item">

                    <span>
                        Shipping Method
                    </span>

                                    <strong>

                                        {{ $shipment->shipping_method ?? '—' }}

                                    </strong>

                                </div>


                                {{-- Tracking Number --}}

                                <div class="info-item">

                    <span>
                        Tracking Number
                    </span>

                                    <strong>

                                        {{ $shipment->tracking_number ?? '—' }}

                                    </strong>

                                </div>


                                {{-- Tracking Link --}}

                                <div class="info-item">

                    <span>
                        Tracking Link
                    </span>

                                    @if($shipment->tracking_url)

                                        <a
                                            href="{{ $shipment->tracking_url }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="view-product"
                                        >

                                            <i class="ri-external-link-line"></i>

                                            Track Shipment

                                        </a>

                                    @else

                                        <strong>
                                            —
                                        </strong>

                                    @endif

                                </div>

                            </div>

                        </div>



                        {{-- ====================================================
                            SHIPPING TIMELINE
                        ==================================================== --}}

                        <div class="shipping-section">

                            <div class="shipping-section-header">

                                <h3>
                                    Shipping Timeline
                                </h3>

                            </div>


                            <div class="info-grid">

                                {{-- Shipped Date --}}

                                <div class="info-item">

                    <span>
                        Shipped At
                    </span>

                                    <strong>

                                        {{
                                            optional(
                                                $shipment->shipped_at
                                            )->format('M d, Y')
                                            ?? 'Not shipped yet'
                                        }}

                                    </strong>

                                </div>


                                {{-- Estimated Delivery --}}

                                <div class="info-item">

                    <span>
                        Estimated Delivery
                    </span>

                                    <strong>

                                        {{
                                            optional(
                                                $shipment->estimated_delivery_at
                                            )->format('M d, Y')
                                            ?? 'Not available'
                                        }}

                                    </strong>

                                </div>


                                {{-- Delivered Date --}}

                                <div class="info-item">

                    <span>
                        Delivered At
                    </span>

                                    <strong>

                                        {{
                                            optional(
                                                $shipment->delivered_at
                                            )->format('M d, Y')
                                            ?? 'Not delivered yet'
                                        }}

                                    </strong>

                                </div>


                                {{-- Created Date --}}

                                <div class="info-item">

                    <span>
                        Shipment Created
                    </span>

                                    <strong>

                                        {{
                                            optional(
                                                $shipment->created_at
                                            )->format('M d, Y')
                                            ?? '—'
                                        }}

                                    </strong>

                                </div>

                            </div>

                        </div>



                        {{-- ====================================================
                            DELIVERY ADDRESS
                        ==================================================== --}}

                        <div class="shipping-section">

                            <div class="shipping-section-header">

                                <h3>
                                    Delivery Address
                                </h3>

                            </div>


                            <div class="shipping-address-box">

                                <div class="shipping-address-icon">

                                    <i class="ri-map-pin-line"></i>

                                </div>


                                <div class="shipping-address-content">

                                    <p>

                                        {{
                                            $shipment->delivery_address
                                            ?? $smartBuy->delivery_address
                                            ?? '—'
                                        }}

                                    </p>


                                    <p>

                                        {{ $shipment->city ?? $smartBuy->city ?? '' }}

                                        @if(
                                            $shipment->zip_code
                                            ?? $smartBuy->zip_code
                                        )

                                            ,
                                            {{
                                                $shipment->zip_code
                                                ?? $smartBuy->zip_code
                                            }}

                                        @endif

                                    </p>


                                    <strong>

                                        {{
                                            $shipment->country
                                            ?? $smartBuy->country
                                            ?? '—'
                                        }}

                                    </strong>

                                </div>

                            </div>

                        </div>



                        {{-- ====================================================
                            SHIPMENT NOTES
                        ==================================================== --}}

                        @if(!empty($shipment->notes))

                            <div class="quote-notes">

                                <div class="quote-notes-icon">

                                    <i class="ri-sticky-note-line"></i>

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



                        {{-- ====================================================
                            SHIPPING ACTIONS
                        ==================================================== --}}

                        <div class="quote-action-bottom">

                            @if($shipment->tracking_url)

                                <a
                                    href="{{ $shipment->tracking_url }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="btn btn-secondary"
                                >

                                    <i class="ri-map-pin-line"></i>

                                    Track Shipment

                                </a>

                            @endif


                            <a
                                href="{{ route('smart-buy.shipment.edit', $shipment->id) }}"
                                class="btn btn-primary"
                            >

                                <i class="ri-edit-line"></i>

                                Edit Shipping

                            </a>

                        </div>


                    @else


                        {{-- ====================================================
                            EMPTY STATE
                        ==================================================== --}}

                        <div class="empty-state">

                            <div class="empty-icon">

                                <i class="ri-truck-line"></i>

                            </div>


                            <h3>
                                No shipment information
                            </h3>


                            <p>

                                @if(
                                    in_array(
                                        $smartBuy->status,
                                        [
                                            'product_purchased',
                                            'in_transit',
                                            'payment_completed'
                                        ]
                                    )
                                )

                                    The products have been purchased. You can now create shipment and tracking information.

                                @else

                                    Shipment and tracking information will appear here once the products are ready to ship.

                                @endif

                            </p>

                        </div>



                        {{-- Create Shipping Action --}}

                        @if(
                            in_array(
                                $smartBuy->status,
                                [
                                    'product_purchased',
                                    'in_transit',
                                    'payment_completed'
                                ]
                            )
                        )

                            <div class="quote-action-bottom">

                                <a
                                    href="{{ route('smart-buy.shipment.create', $smartBuy->id) }}"
                                    class="btn btn-primary"
                                >

                                    <i class="ri-add-circle-line"></i>

                                    Create Shipment

                                </a>

                            </div>

                        @endif

                    @endif

                </div>


            </div>


            {{-- ========================================================
                RIGHT SIDEBAR
            ======================================================== --}}

            <aside class="sidebar-column">


                {{-- Customer Information --}}

                <div class="smart-buy-card sidebar-card">

                    <div class="card-header">

                        <div class="card-heading">

                            <div class="card-icon">
                                <i class="ri-user-3-line"></i>
                            </div>

                            <div>

                                <h2>
                                    Customer Information
                                </h2>

                            </div>

                        </div>

                    </div>


                    <div class="customer-profile">

                        <div class="customer-avatar">

                            {{ strtoupper(
                                substr(
                                    $smartBuy->first_name ?? 'U',
                                    0,
                                    1
                                )
                            ) }}

                        </div>


                        <div>

                            <h3>

                                {{ $smartBuy->first_name }}

                                {{ $smartBuy->last_name }}

                            </h3>


                            <span>

                                {{ $smartBuy->user
                                    ? 'Registered Customer'
                                    : 'Guest Customer' }}

                            </span>

                        </div>

                    </div>


                    <div class="sidebar-info-list">


                        <div class="sidebar-info-row">

                            <i class="ri-mail-line"></i>

                            <div>

                                <span>
                                    Email
                                </span>

                                <strong>
                                    {{ $smartBuy->email ?? '—' }}
                                </strong>

                            </div>

                        </div>


                        <div class="sidebar-info-row">

                            <i class="ri-phone-line"></i>

                            <div>

                                <span>
                                    Phone
                                </span>

                                <strong>
                                    {{ $smartBuy->phone ?? '—' }}
                                </strong>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- Delivery Address --}}

                <div class="smart-buy-card sidebar-card">

                    <div class="card-header">

                        <div class="card-heading">

                            <div class="card-icon">
                                <i class="ri-map-pin-line"></i>
                            </div>

                            <div>

                                <h2>
                                    Delivery Address
                                </h2>

                            </div>

                        </div>

                    </div>


                    <div class="address-content">

                        <p>
                            {{ $smartBuy->delivery_address ?? '—' }}
                        </p>

                        <p>

                            {{ $smartBuy->city ?? '' }}

                            {{ $smartBuy->zip_code
                                ? ', ' . $smartBuy->zip_code
                                : '' }}

                        </p>

                        <strong>
                            {{ $smartBuy->country ?? '—' }}
                        </strong>

                    </div>

                </div>


                {{-- Request Information --}}

                <div class="smart-buy-card sidebar-card">

                    <div class="card-header">

                        <div class="card-heading">

                            <div class="card-icon">
                                <i class="ri-information-line"></i>
                            </div>

                            <div>

                                <h2>
                                    Request Information
                                </h2>

                            </div>

                        </div>

                    </div>


                    <div class="request-info-list">

                        <div>

                            <span>
                                Request ID
                            </span>

                            <strong>
                                {{ $smartBuy->request_number }}
                            </strong>

                        </div>


                        <div>

                            <span>
                                Created
                            </span>

                            <strong>

                                {{ optional(
                                    $smartBuy->created_at
                                )->format('M d, Y') }}

                            </strong>

                        </div>


                        <div>

                            <span>
                                Last Updated
                            </span>

                            <strong>

                                {{ optional(
                                    $smartBuy->updated_at
                                )->diffForHumans() }}

                            </strong>

                        </div>

                    </div>

                </div>


                {{-- Update Status --}}

                <div
                    class="smart-buy-card sidebar-card"
                    id="status-section"
                >

                    <div class="card-header">

                        <div class="card-heading">

                            <div class="card-icon">
                                <i class="ri-refresh-line"></i>
                            </div>

                            <div>

                                <h2>
                                    Update Status
                                </h2>

                            </div>

                        </div>

                    </div>


                    <form
                        action="{{ url('/portal/smart-buy/' . $smartBuy->id . '/status') }}"
                        method="POST"
                        class="status-form"
                    >

                        @csrf

                        @method('PUT')


                        <select name="status">

                            @foreach($statusLabels as $value => $label)

                                <option
                                    value="{{ $value }}"
                                    @selected($smartBuy->status === $value)
                                >

                                    {{ $label }}

                                </option>

                            @endforeach

                        </select>


                        <button
                            type="submit"
                            class="btn btn-save-status"
                        >

                            <i class="ri-check-line"></i>

                            Save Status

                        </button>

                    </form>

                </div>


            </aside>

        </div>

    </div>

@endsection
