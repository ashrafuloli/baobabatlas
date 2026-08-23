@extends('backend.layouts.backend')

@section('title', 'My Smart Buy')

@section('content')

    @php

        $statusConfig = [

            'pending' => [
                'label' => 'Pending Review',
                'class' => 'status-pending',
                'icon' => 'fa-solid fa-clock',
                'progress' => 10,
            ],

            'quote_sent' => [
                'label' => 'Quote Available',
                'class' => 'status-quote-sent',
                'icon' => 'fa-solid fa-file-invoice-dollar',
                'progress' => 25,
            ],

            'quote_accepted' => [
                'label' => 'Awaiting Payment',
                'class' => 'status-quote-accepted',
                'icon' => 'fa-solid fa-credit-card',
                'progress' => 40,
            ],

            'quote_rejected' => [
                'label' => 'Quote Rejected',
                'class' => 'status-rejected',
                'icon' => 'fa-solid fa-circle-xmark',
                'progress' => 25,
            ],

            'payment_completed' => [
                'label' => 'Payment Completed',
                'class' => 'status-payment',
                'icon' => 'fa-solid fa-circle-check',
                'progress' => 55,
            ],

            'product_purchased' => [
                'label' => 'Products Purchased',
                'class' => 'status-purchased',
                'icon' => 'fa-solid fa-bag-shopping',
                'progress' => 70,
            ],

            'in_transit' => [
                'label' => 'In Transit',
                'class' => 'status-transit',
                'icon' => 'fa-solid fa-truck-fast',
                'progress' => 85,
            ],

            'completed' => [
                'label' => 'Completed',
                'class' => 'status-completed',
                'icon' => 'fa-solid fa-circle-check',
                'progress' => 100,
            ],

            'cancelled' => [
                'label' => 'Cancelled',
                'class' => 'status-cancelled',
                'icon' => 'fa-solid fa-ban',
                'progress' => 0,
            ],

        ];

    @endphp


    <div class="my-smart-buy-page">

        {{-- ============================================================
            PAGE HEADER
        ============================================================ --}}

        <div class="smart-buy-page-header">

            <div class="smart-buy-header-content">

                <div class="smart-buy-header-text">

                    <div class="smart-buy-header-icon">
                        <i class="fa-solid fa-bag-shopping"></i>
                    </div>

                    <div>

                        <h1>My Smart Buy</h1>

                        <p>
                            Manage your product requests, quotes, payments,
                            and deliveries in one place.
                        </p>

                    </div>

                </div>


                <a
                    href="{{ route('my-smart-buy-create') }}"
                    class="smart-buy-create-btn"
                >
                    <i class="fa-solid fa-plus"></i>

                    <span>New Request</span>
                </a>

            </div>

        </div>



        {{-- ============================================================
            STATISTICS
        ============================================================ --}}

        <div class="smart-buy-stats-grid">

            {{-- Total Requests --}}

            <div class="smart-buy-stat-card">

                <div class="stat-icon stat-icon-blue">

                    <i class="fa-solid fa-layer-group"></i>

                </div>

                <div class="stat-content">

                    <span>Total Requests</span>

                    <strong>
                        {{ number_format($totalRequests ?? 0) }}
                    </strong>

                </div>

            </div>


            {{-- Pending --}}

            <div class="smart-buy-stat-card">

                <div class="stat-icon stat-icon-warning">

                    <i class="fa-solid fa-clock"></i>

                </div>

                <div class="stat-content">

                    <span>Pending</span>

                    <strong>
                        {{ number_format($pendingRequests ?? 0) }}
                    </strong>

                </div>

            </div>


            {{-- Awaiting Payment --}}

            <div class="smart-buy-stat-card">

                <div class="stat-icon stat-icon-purple">

                    <i class="fa-solid fa-credit-card"></i>

                </div>

                <div class="stat-content">

                    <span>Awaiting Payment</span>

                    <strong>
                        {{ number_format($awaitingPayment ?? 0) }}
                    </strong>

                </div>

            </div>


            {{-- In Progress --}}

            <div class="smart-buy-stat-card">

                <div class="stat-icon stat-icon-green">

                    <i class="fa-solid fa-truck-fast"></i>

                </div>

                <div class="stat-content">

                    <span>In Progress</span>

                    <strong>
                        {{ number_format($inProgress ?? 0) }}
                    </strong>

                </div>

            </div>

        </div>



        {{-- ============================================================
            REQUEST LIST
        ============================================================ --}}

        <div class="smart-buy-main-card">


            {{-- CARD HEADER --}}

            <div class="smart-buy-card-header">

                <div>

                    <h2>
                        My Requests
                    </h2>

                    <p>
                        Track the progress of all your Smart Buy requests.
                    </p>

                </div>


                <div class="smart-buy-total-count">

                    {{ $smartBuys->total() }}

                    <span>
                    {{ $smartBuys->total() === 1 ? 'Request' : 'Requests' }}
                </span>

                </div>

            </div>



            {{-- ========================================================
                FILTER FORM
            ======================================================== --}}

            <form
                action="{{ route('my-smart-buy') }}"
                method="GET"
                class="smart-buy-filter-form"
                id="smartBuyFilterForm"
            >


                {{-- Search --}}

                <div class="smart-buy-search">

                    <i class="fa-solid fa-magnifying-glass"></i>

                    <input
                        type="text"
                        name="search"
                        id="smartBuySearch"
                        value="{{ request('search') }}"
                        placeholder="Search by request number..."
                    >

                </div>



                {{-- Status Filter --}}

                <div class="smart-buy-filter-select">

                    <select
                        name="status"
                        id="smartBuyStatus"
                    >

                        <option value="all">
                            All Status
                        </option>


                        @foreach($statusConfig as $statusKey => $status)

                            <option
                                value="{{ $statusKey }}"
                                @selected(request('status') === $statusKey)
                            >
                                {{ $status['label'] }}
                            </option>

                        @endforeach

                    </select>

                    <i class="fa-solid fa-chevron-down"></i>

                </div>



                {{-- Country Filter --}}

                <div class="smart-buy-filter-select">

                    <select
                        name="country"
                        id="smartBuyCountry"
                    >

                        <option value="all">
                            All Countries
                        </option>

                        @foreach($countries ?? [] as $country)

                            <option
                                value="{{ $country }}"
                                @selected(request('country') === $country)
                            >
                                {{ $country }}
                            </option>

                        @endforeach

                    </select>

                    <i class="fa-solid fa-chevron-down"></i>

                </div>



                {{-- Date Filter --}}

                <div class="smart-buy-filter-select">

                    <select
                        name="date"
                        id="smartBuyDate"
                    >

                        <option value="all">
                            All Time
                        </option>

                        <option
                            value="today"
                            @selected(request('date') === 'today')
                        >
                            Today
                        </option>

                        <option
                            value="week"
                            @selected(request('date') === 'week')
                        >
                            This Week
                        </option>

                        <option
                            value="month"
                            @selected(request('date') === 'month')
                        >
                            This Month
                        </option>

                    </select>

                    <i class="fa-solid fa-chevron-down"></i>

                </div>



                {{-- Filter Button --}}

                <button
                    type="submit"
                    class="smart-buy-filter-btn"
                >

                    <i class="fa-solid fa-filter"></i>

                    <span>
                    Filter
                </span>

                </button>



                {{-- Reset --}}

                @if(
                    request()->filled('search')
                    || request('status') !== null && request('status') !== 'all'
                    || request('country') !== null && request('country') !== 'all'
                    || request('date') !== null && request('date') !== 'all'
                )

                    <a
                        href="{{ route('my-smart-buy') }}"
                        class="smart-buy-reset-btn"
                    >

                        <i class="fa-solid fa-rotate-left"></i>

                        <span>
                        Reset
                    </span>

                    </a>

                @endif


            </form>



            {{-- ========================================================
                REQUESTS
            ======================================================== --}}

            @if($smartBuys->count())


                <div class="smart-buy-request-list">


                    @foreach($smartBuys as $smartBuy)

                        @php

                            $statusKey = $smartBuy->status ?? 'pending';

                            $status = $statusConfig[$statusKey]
                                ?? $statusConfig['pending'];

                            $itemsCount = $smartBuy->items->count();

                            $firstItem = $smartBuy->items->first();

                            $quote = $smartBuy->quote;

                            $payment = $smartBuy->payment;

                            $shipment = $smartBuy->shipment;

                        @endphp


                        <div class="smart-buy-request-card">


                            {{-- ====================================================
                                REQUEST TOP
                            ==================================================== --}}

                            <div class="request-card-top">


                                {{-- REQUEST INFO --}}

                                <div class="request-main-info">


                                    <div class="request-number-box">

                                    <span>
                                        Request
                                    </span>

                                        <strong>
                                            #{{ $smartBuy->request_number }}
                                        </strong>

                                    </div>


                                    <div class="request-meta">

                                    <span>

                                        <i class="fa-regular fa-calendar"></i>

                                        {{ $smartBuy->created_at?->format('d M Y') }}

                                    </span>


                                        <span>

                                        <i class="fa-solid fa-box"></i>

                                        {{ $itemsCount }}

                                            {{ $itemsCount === 1 ? 'Item' : 'Items' }}

                                    </span>

                                    </div>


                                </div>



                                {{-- STATUS --}}

                                <div
                                    class="request-status {{ $status['class'] }}"
                                >

                                    <i class="{{ $status['icon'] }}"></i>

                                    <span>
                                    {{ $status['label'] }}
                                </span>

                                </div>


                            </div>



                            {{-- ====================================================
                                PRODUCT PREVIEW
                            ==================================================== --}}

                            <div class="request-product-preview">


                                <div class="request-product-image">

                                    @if(
                                        $firstItem
                                        && !empty($firstItem->product_image)
                                    )

                                        <img
                                            src="{{ asset('storage/' . $firstItem->product_image) }}"
                                            alt="{{ $firstItem->product_name }}"
                                        >

                                    @else

                                        <div class="product-image-placeholder">

                                            <i class="fa-solid fa-image"></i>

                                        </div>

                                    @endif

                                </div>



                                <div class="request-product-content">


                                <span class="product-label">

                                    Requested Product

                                </span>


                                    <h3>

                                        {{ $firstItem?->product_name ?? 'Product Request' }}

                                    </h3>


                                    @if($firstItem)

                                        <div class="product-details">

                                        <span>

                                            Qty:
                                            <strong>
                                                {{ $firstItem->quantity }}
                                            </strong>

                                        </span>


                                            @if($firstItem->size)

                                                <span>

                                                Size:
                                                <strong>
                                                    {{ $firstItem->size }}
                                                </strong>

                                            </span>

                                            @endif


                                            @if($firstItem->color)

                                                <span>

                                                Color:
                                                <strong>
                                                    {{ $firstItem->color }}
                                                </strong>

                                            </span>

                                            @endif

                                        </div>

                                    @endif


                                    @if($itemsCount > 1)

                                        <div class="additional-products">

                                            <i class="fa-solid fa-plus"></i>

                                            {{ $itemsCount - 1 }}

                                            more

                                            {{ $itemsCount - 1 === 1 ? 'item' : 'items' }}

                                        </div>

                                    @endif


                                </div>


                            </div>



                            {{-- ====================================================
                                PROGRESS
                            ==================================================== --}}

                            <div class="request-progress-section">


                                <div class="progress-header">

                                <span>
                                    Request Progress
                                </span>


                                    <strong>
                                        {{ $status['progress'] }}%
                                    </strong>

                                </div>


                                <div class="request-progress-bar">

                                    <div
                                        class="request-progress-fill"
                                        style="width: {{ $status['progress'] }}%"
                                    ></div>

                                </div>


                                <div class="request-progress-steps">


                                <span
                                    class="{{ $status['progress'] >= 10 ? 'active' : '' }}"
                                >
                                    Request
                                </span>


                                    <span
                                        class="{{ $status['progress'] >= 25 ? 'active' : '' }}"
                                    >
                                    Quote
                                </span>


                                    <span
                                        class="{{ $status['progress'] >= 55 ? 'active' : '' }}"
                                    >
                                    Payment
                                </span>


                                    <span
                                        class="{{ $status['progress'] >= 85 ? 'active' : '' }}"
                                    >
                                    Shipping
                                </span>


                                    <span
                                        class="{{ $status['progress'] >= 100 ? 'active' : '' }}"
                                    >
                                    Completed
                                </span>


                                </div>


                            </div>



                            {{-- ====================================================
                                REQUEST FOOTER
                            ==================================================== --}}

                            <div class="request-card-footer">


                                {{-- LEFT STATUS INFO --}}

                                <div class="request-extra-info">


                                    {{-- Quote --}}

                                    @if($quote)

                                        <div class="request-info-item">

                                            <i class="fa-solid fa-file-invoice-dollar"></i>

                                            <div>

                                            <span>
                                                Quote
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

                                        </div>

                                    @endif



                                    {{-- Payment --}}

                                    @if($payment)

                                        <div class="request-info-item">

                                            <i class="fa-solid fa-credit-card"></i>

                                            <div>

                                            <span>
                                                Payment
                                            </span>

                                                <strong>

                                                    {{ ucfirst(
                                                        str_replace(
                                                            '_',
                                                            ' ',
                                                            $payment->status
                                                        )
                                                    ) }}

                                                </strong>

                                            </div>

                                        </div>

                                    @endif



                                    {{-- Shipment --}}

                                    @if($shipment)

                                        <div class="request-info-item">

                                            <i class="fa-solid fa-truck"></i>

                                            <div>

                                            <span>
                                                Shipment
                                            </span>

                                                <strong>

                                                    {{ ucfirst(
                                                        str_replace(
                                                            '_',
                                                            ' ',
                                                            $shipment->status
                                                        )
                                                    ) }}

                                                </strong>

                                            </div>

                                        </div>

                                    @endif


                                </div>



                                {{-- ACTIONS --}}

                                <div class="request-actions">


                                    {{-- VIEW DETAILS --}}

                                    <a
                                        href="{{ route('my-smart-buy-details', $smartBuy->id) }}"
                                        class="request-action-btn request-view-btn"
                                    >

                                        <i class="fa-regular fa-eye"></i>

                                        <span>
                                        View Details
                                    </span>

                                    </a>



                                    {{-- VIEW QUOTE --}}

                                    @if(
                                        in_array(
                                            $statusKey,
                                            [
                                                'quote_sent',
                                                'quote_accepted',
                                                'payment_completed',
                                                'product_purchased',
                                                'in_transit',
                                                'completed'
                                            ]
                                        )
                                        && $quote
                                    )

                                        <a
                                            href="{{ route('my-smart-buy-quote', $smartBuy) }}"
                                            class="request-action-btn request-quote-btn"
                                        >

                                            <i class="fa-solid fa-file-invoice-dollar"></i>

                                            <span>
                                            View Quote
                                        </span>

                                        </a>

                                    @endif



                                    {{-- PAYMENT --}}

                                    @if($statusKey === 'quote_accepted')

                                        <a
                                            href="{{ route('smart-buy-payment', $smartBuy) }}"
                                            class="request-action-btn request-payment-btn"
                                        >

                                            <i class="fa-solid fa-credit-card"></i>

                                            <span>
                                            Make Payment
                                        </span>

                                        </a>

                                    @endif



                                    {{-- TRACK SHIPMENT --}}

                                    @if(
                                        in_array(
                                            $statusKey,
                                            [
                                                'in_transit',
                                                'completed'
                                            ]
                                        )
                                    )

                                        <a
                                            href="{{ route('smart-buy-tracking', $smartBuy) }}"
                                            class="request-action-btn request-track-btn"
                                        >

                                            <i class="fa-solid fa-location-dot"></i>

                                            <span>
                                            Track
                                        </span>

                                        </a>

                                    @endif


                                </div>


                            </div>


                        </div>

                    @endforeach


                </div>



                {{-- ====================================================
                    PAGINATION
                ==================================================== --}}

                @if($smartBuys->hasPages())

                    <div class="smart-buy-pagination">

                        {{ $smartBuys->links() }}

                    </div>

                @endif


            @else


                {{-- ====================================================
                    EMPTY STATE
                ==================================================== --}}

                <div class="smart-buy-empty-state">


                    <div class="empty-state-icon">

                        <i class="fa-solid fa-bag-shopping"></i>

                    </div>


                    <h3>
                        No Smart Buy Requests Found
                    </h3>


                    <p>

                        You have not created any Smart Buy request yet.

                        Start by adding the products you would like us to purchase.

                    </p>


                    <a
                        href="{{ route('my-smart-buy-create') }}"
                        class="smart-buy-create-btn"
                    >

                        <i class="fa-solid fa-plus"></i>

                        <span>
                        Create Your First Request
                    </span>

                    </a>


                </div>


            @endif


        </div>


    </div>

@endsection



@push('scripts')

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const filterForm = document.getElementById(
                'smartBuyFilterForm'
            );

            const searchInput = document.getElementById(
                'smartBuySearch'
            );

            const statusSelect = document.getElementById(
                'smartBuyStatus'
            );

            const countrySelect = document.getElementById(
                'smartBuyCountry'
            );

            const dateSelect = document.getElementById(
                'smartBuyDate'
            );


            /*
            |--------------------------------------------------------------------------
            | Auto Submit Select Filters
            |--------------------------------------------------------------------------
            */

            [
                statusSelect,
                countrySelect,
                dateSelect
            ].forEach(function (element) {

                if (!element) {
                    return;
                }


                element.addEventListener(
                    'change',
                    function () {

                        filterForm.submit();

                    }
                );

            });



            /*
            |--------------------------------------------------------------------------
            | Search On Enter
            |--------------------------------------------------------------------------
            */

            if (searchInput) {

                searchInput.addEventListener(
                    'keydown',
                    function (event) {

                        if (event.key === 'Enter') {

                            event.preventDefault();

                            filterForm.submit();

                        }

                    }
                );

            }



            /*
            |--------------------------------------------------------------------------
            | Animate Progress Bars
            |--------------------------------------------------------------------------
            */

            const progressBars = document.querySelectorAll(
                '.request-progress-fill'
            );


            progressBars.forEach(function (bar) {

                const progress = bar.style.width;

                bar.style.width = '0%';


                setTimeout(function () {

                    bar.style.width = progress;

                }, 100);

            });



            /*
            |--------------------------------------------------------------------------
            | Confirm Payment Navigation
            |--------------------------------------------------------------------------
            */

            const paymentButtons = document.querySelectorAll(
                '.request-payment-btn'
            );


            paymentButtons.forEach(function (button) {

                button.addEventListener(
                    'click',
                    function () {

                        button.classList.add(
                            'is-loading'
                        );

                    }
                );

            });

        });

    </script>

@endpush
