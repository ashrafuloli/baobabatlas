@extends('backend.layouts.backend')

@section('title', 'Smart Buy Management')

@section('content')

    <div class="smart-buy-admin-page">

        {{-- =========================================================
            PAGE HEADER
        ========================================================= --}}
        <div class="smart-buy-admin-header">

            <div class="smart-buy-admin-header__content">

                <div class="smart-buy-admin-header__icon">
                    <i class="fa-solid fa-bag-shopping"></i>
                </div>

                <div>
                    <h1>Smart Buy Management</h1>

                    <p>
                        Review customer requests, manage quotes, payments, purchases and shipments.
                    </p>
                </div>

            </div>

            <div class="smart-buy-admin-header__actions">

                <a
                    href="{{ route('payments-smart-buy') }}"
                    class="smart-buy-admin-header__button smart-buy-admin-header__button--outline"
                >
                    <i class="fa-solid fa-credit-card"></i>
                    <span>Payments</span>
                </a>

            </div>

        </div>


        {{-- =========================================================
            STATISTICS
        ========================================================= --}}
        <div class="smart-buy-admin-stats">

            {{-- Total Requests --}}
            <div class="smart-buy-admin-stat-card">

                <div class="smart-buy-admin-stat-card__icon smart-buy-admin-stat-card__icon--blue">
                    <i class="fa-solid fa-layer-group"></i>
                </div>

                <div class="smart-buy-admin-stat-card__content">

                    <span>Total Requests</span>

                    <strong>
                        {{ $totalRequests ?? 0 }}
                    </strong>

                </div>

            </div>


            {{-- Pending --}}
            <div class="smart-buy-admin-stat-card">

                <div class="smart-buy-admin-stat-card__icon smart-buy-admin-stat-card__icon--warning">
                    <i class="fa-solid fa-clock"></i>
                </div>

                <div class="smart-buy-admin-stat-card__content">

                    <span>Pending Review</span>

                    <strong>
                        {{ $pendingRequests ?? 0 }}
                    </strong>

                </div>

            </div>


            {{-- Awaiting Payment --}}
            <div class="smart-buy-admin-stat-card">

                <div class="smart-buy-admin-stat-card__icon smart-buy-admin-stat-card__icon--purple">
                    <i class="fa-solid fa-credit-card"></i>
                </div>

                <div class="smart-buy-admin-stat-card__content">

                    <span>Awaiting Payment</span>

                    <strong>
                        {{ $awaitingPayment ?? 0 }}
                    </strong>

                </div>

            </div>


            {{-- In Progress --}}
            <div class="smart-buy-admin-stat-card">

                <div class="smart-buy-admin-stat-card__icon smart-buy-admin-stat-card__icon--green">
                    <i class="fa-solid fa-truck"></i>
                </div>

                <div class="smart-buy-admin-stat-card__content">

                    <span>In Progress</span>

                    <strong>
                        {{ $inProgress ?? 0 }}
                    </strong>

                </div>

            </div>

        </div>


        {{-- =========================================================
            REQUEST LIST
        ========================================================= --}}
        <div class="smart-buy-admin-list-card">


            {{-- List Header --}}
            <div class="smart-buy-admin-list-card__header">

                <div>

                    <h2>Smart Buy Requests</h2>

                    <p>
                        Manage and track all customer Smart Buy requests.
                    </p>

                </div>


                <div class="smart-buy-admin-list-card__count">

                    <strong>
                        {{ $smartBuys->total() }}
                    </strong>

                    <span>Requests</span>

                </div>

            </div>


            {{-- =====================================================
                FILTER FORM
            ===================================================== --}}
            <form
                action="{{ route('smart-buy') }}"
                method="GET"
                class="smart-buy-admin-filters"
            >

                {{-- Search --}}
                <div class="smart-buy-admin-filter-search">

                    <i class="fa-solid fa-magnifying-glass"></i>

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search by request or customer"
                    >

                </div>


                {{-- Status --}}
                <div class="smart-buy-admin-filter-select">

                    <select name="status">

                        <option value="all">
                            All Status
                        </option>

                        <option
                            value="pending"
                            @selected(request('status') === 'pending')
                        >
                            Pending
                        </option>

                        <option
                            value="quote_sent"
                            @selected(request('status') === 'quote_sent')
                        >
                            Quote Sent
                        </option>

                        <option
                            value="quote_accepted"
                            @selected(request('status') === 'quote_accepted')
                        >
                            Quote Accepted
                        </option>

                        <option
                            value="quote_rejected"
                            @selected(request('status') === 'quote_rejected')
                        >
                            Quote Rejected
                        </option>

                        <option
                            value="payment_completed"
                            @selected(request('status') === 'payment_completed')
                        >
                            Payment Completed
                        </option>

                        <option
                            value="product_purchased"
                            @selected(request('status') === 'product_purchased')
                        >
                            Product Purchased
                        </option>

                        <option
                            value="in_transit"
                            @selected(request('status') === 'in_transit')
                        >
                            In Transit
                        </option>

                        <option
                            value="completed"
                            @selected(request('status') === 'completed')
                        >
                            Completed
                        </option>

                        <option
                            value="cancelled"
                            @selected(request('status') === 'cancelled')
                        >
                            Cancelled
                        </option>

                    </select>

                </div>


                {{-- Country --}}
                <div class="smart-buy-admin-filter-select">

                    <select name="country">

                        <option value="all">
                            All Countries
                        </option>

                        @foreach($countries as $country)

                            <option
                                value="{{ $country }}"
                                @selected(request('country') === $country)
                            >
                                {{ config('countries.' . $country, $country) }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- Date --}}
                <div class="smart-buy-admin-filter-select">

                    <select name="date">

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

                </div>


                {{-- Filter --}}
                <button
                    type="submit"
                    class="smart-buy-admin-filter-button"
                >

                    <i class="fa-solid fa-filter"></i>

                    Filter

                </button>


                {{-- Reset --}}
                @if(
                    request()->filled('search')
                    || request('status') !== null
                    || request('country') !== null
                    || request('date') !== null
                )

                    <a
                        href="{{ route('smart-buy') }}"
                        class="smart-buy-admin-reset-button"
                    >
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>

                @endif

            </form>


            {{-- =====================================================
                REQUESTS
            ===================================================== --}}
            <div class="smart-buy-admin-requests">

                @forelse($smartBuys as $smartBuy)

                    @php

                        /*
                        |--------------------------------------------------------------------------
                        | Main Product
                        |--------------------------------------------------------------------------
                        */

                        $firstItem = $smartBuy->items->first();


                        /*
                        |--------------------------------------------------------------------------
                        | Total Items
                        |--------------------------------------------------------------------------
                        */

                        $totalItems = $smartBuy->items->count();


                        /*
                        |--------------------------------------------------------------------------
                        | Current Status
                        |--------------------------------------------------------------------------
                        */

                        $status = $smartBuy->status;


                        /*
                        |--------------------------------------------------------------------------
                        | Progress
                        |--------------------------------------------------------------------------
                        */

                        $progress = match ($status) {

                            'pending' => 10,

                            'quote_sent' => 25,

                            'quote_accepted' => 35,

                            'payment_completed' => 50,

                            'product_purchased' => 70,

                            'in_transit' => 85,

                            'completed' => 100,

                            'quote_rejected',
                            'cancelled' => 0,

                            default => 10,

                        };


                        /*
                        |--------------------------------------------------------------------------
                        | Status Label
                        |--------------------------------------------------------------------------
                        */

                        $statusLabel = match ($status) {

                            'pending' =>
                                'Pending Review',

                            'quote_sent' =>
                                'Quote Sent',

                            'quote_accepted' =>
                                'Awaiting Payment',

                            'payment_completed' =>
                                'Payment Completed',

                            'product_purchased' =>
                                'Product Purchased',

                            'in_transit' =>
                                'In Transit',

                            'completed' =>
                                'Completed',

                            'quote_rejected' =>
                                'Quote Rejected',

                            'cancelled' =>
                                'Cancelled',

                            default =>
                                ucfirst(str_replace('_', ' ', $status)),

                        };


                        /*
                        |--------------------------------------------------------------------------
                        | Status Class
                        |--------------------------------------------------------------------------
                        */

                        $statusClass = match ($status) {

                            'pending' =>
                                'warning',

                            'quote_sent' =>
                                'info',

                            'quote_accepted' =>
                                'purple',

                            'payment_completed' =>
                                'success',

                            'product_purchased' =>
                                'blue',

                            'in_transit' =>
                                'primary',

                            'completed' =>
                                'success',

                            'quote_rejected',
                            'cancelled' =>
                                'danger',

                            default =>
                                'default',

                        };

                    @endphp


                    <div class="smart-buy-admin-request">


                        {{-- =================================================
                            REQUEST TOP
                        ================================================= --}}
                        <div class="smart-buy-admin-request__top">


                            <div class="smart-buy-admin-request__info">

                            <span class="smart-buy-admin-request__eyebrow">
                                REQUEST
                            </span>


                                <div class="smart-buy-admin-request__meta">

                                    <strong>
                                        #{{ $smartBuy->request_number }}
                                    </strong>


                                    <span>
                                    <i class="fa-regular fa-calendar"></i>

                                    {{ $smartBuy->created_at->format('d M Y') }}
                                </span>


                                    <span>
                                    <i class="fa-solid fa-box"></i>

                                    {{ $totalItems }}
                                        {{ Str::plural('Item', $totalItems) }}
                                </span>


                                    <span>
                                    <i class="fa-regular fa-user"></i>

                                    {{ $smartBuy->first_name }}
                                        {{ $smartBuy->last_name }}
                                </span>

                                </div>

                            </div>


                            <div
                                class="smart-buy-admin-status smart-buy-admin-status--{{ $statusClass }}"
                            >

                                @if($status === 'pending')

                                    <i class="fa-solid fa-clock"></i>

                                @elseif($status === 'quote_sent')

                                    <i class="fa-solid fa-file-invoice"></i>

                                @elseif($status === 'quote_accepted')

                                    <i class="fa-solid fa-credit-card"></i>

                                @elseif($status === 'payment_completed')

                                    <i class="fa-solid fa-circle-check"></i>

                                @elseif($status === 'product_purchased')

                                    <i class="fa-solid fa-bag-shopping"></i>

                                @elseif($status === 'in_transit')

                                    <i class="fa-solid fa-truck"></i>

                                @elseif($status === 'completed')

                                    <i class="fa-solid fa-circle-check"></i>

                                @else

                                    <i class="fa-solid fa-circle-info"></i>

                                @endif

                                {{ $statusLabel }}

                            </div>

                        </div>


                        {{-- =================================================
                            PRODUCT
                        ================================================= --}}
                        <div class="smart-buy-admin-request__product">


                            {{-- Product Image --}}
                            <div class="smart-buy-admin-product-image">

                                @if(
                                    $firstItem
                                    && $firstItem->product_image
                                )

                                    <img
                                        src="{{ asset($firstItem->product_image) }}"
                                        alt="{{ $firstItem->product_name }}"
                                    >

                                @else

                                    <div class="smart-buy-admin-product-placeholder">

                                        <i class="fa-solid fa-image"></i>

                                    </div>

                                @endif

                            </div>


                            {{-- Product Details --}}
                            <div class="smart-buy-admin-product-details">

                            <span>
                                REQUESTED PRODUCT
                            </span>


                                <h3>
                                    {{ $firstItem?->product_name ?? 'Product Request' }}
                                </h3>


                                @if($firstItem)

                                    <div class="smart-buy-admin-product-details__meta">

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


                                @if($totalItems > 1)

                                    <div class="smart-buy-admin-more-items">

                                        + {{ $totalItems - 1 }}
                                        more
                                        {{ Str::plural('item', $totalItems - 1) }}

                                    </div>

                                @endif

                            </div>


                            {{-- Customer --}}
                            <div class="smart-buy-admin-customer">

                                <span>CUSTOMER</span>

                                <strong>
                                    {{ $smartBuy->first_name }}
                                    {{ $smartBuy->last_name }}
                                </strong>

                                <small>
                                    {{ $smartBuy->email }}
                                </small>

                            </div>

                        </div>


                        {{-- =================================================
                            PROGRESS
                        ================================================= --}}
                        <div class="smart-buy-admin-progress">

                            <div class="smart-buy-admin-progress__header">

                            <span>
                                Request Progress
                            </span>

                                <strong>
                                    {{ $progress }}%
                                </strong>

                            </div>


                            <div class="smart-buy-admin-progress__bar">

                                <div
                                    class="smart-buy-admin-progress__fill"
                                    style="width: {{ $progress }}%;"
                                ></div>

                            </div>


                            <div class="smart-buy-admin-progress__steps">

                            <span
                                class="{{ $progress >= 10 ? 'is-active' : '' }}"
                            >
                                Request
                            </span>

                                <span
                                    class="{{ $progress >= 25 ? 'is-active' : '' }}"
                                >
                                Quote
                            </span>

                                <span
                                    class="{{ $progress >= 50 ? 'is-active' : '' }}"
                                >
                                Payment
                            </span>

                                <span
                                    class="{{ $progress >= 70 ? 'is-active' : '' }}"
                                >
                                Purchase
                            </span>

                                <span
                                    class="{{ $progress >= 85 ? 'is-active' : '' }}"
                                >
                                Shipping
                            </span>

                                <span
                                    class="{{ $progress >= 100 ? 'is-active' : '' }}"
                                >
                                Completed
                            </span>

                            </div>

                        </div>


                        {{-- =================================================
                            ACTIONS
                        ================================================= --}}
                        <div class="smart-buy-admin-request__actions">


                            {{-- Quote Status --}}
                            @if(
                                $status === 'pending'
                            )

                                <span class="smart-buy-admin-action-info">

                                <i class="fa-solid fa-file-invoice"></i>

                                Quote Required

                            </span>

                            @elseif(
                                $status === 'quote_sent'
                            )

                                <span class="smart-buy-admin-action-info smart-buy-admin-action-info--info">

                                <i class="fa-solid fa-clock"></i>

                                Waiting for Customer

                            </span>

                            @elseif(
                                $status === 'quote_accepted'
                            )

                                <span class="smart-buy-admin-action-info smart-buy-admin-action-info--purple">

                                <i class="fa-solid fa-credit-card"></i>

                                Awaiting Payment

                            </span>

                            @elseif(
                                $status === 'payment_completed'
                            )

                                <span class="smart-buy-admin-action-info smart-buy-admin-action-info--success">

                                <i class="fa-solid fa-circle-check"></i>

                                Ready to Purchase

                            </span>

                            @elseif(
                                $status === 'product_purchased'
                            )

                                <span class="smart-buy-admin-action-info smart-buy-admin-action-info--blue">

                                <i class="fa-solid fa-truck"></i>

                                Shipment Required

                            </span>

                            @elseif(
                                $status === 'in_transit'
                            )

                                <span class="smart-buy-admin-action-info smart-buy-admin-action-info--primary">

                                <i class="fa-solid fa-truck-fast"></i>

                                Shipment Active

                            </span>

                            @endif


                            {{-- Manage Button --}}
                            <a
                                href="{{ route('smart-buy.details', $smartBuy) }}"
                                class="smart-buy-admin-view-button"
                            >

                                <i class="fa-regular fa-eye"></i>

                                Manage Request

                            </a>

                        </div>


                    </div>

                @empty


                    {{-- =================================================
                        EMPTY STATE
                    ================================================= --}}
                    <div class="smart-buy-admin-empty">

                        <div class="smart-buy-admin-empty__icon">

                            <i class="fa-solid fa-bag-shopping"></i>

                        </div>

                        <h3>
                            No Smart Buy Requests Found
                        </h3>

                        <p>
                            There are currently no Smart Buy requests matching your filters.
                        </p>


                        @if(
                            request()->hasAny([
                                'search',
                                'status',
                                'country',
                                'date'
                            ])
                        )

                            <a
                                href="{{ route('smart-buy') }}"
                                class="smart-buy-admin-empty__button"
                            >
                                Reset Filters
                            </a>

                        @endif

                    </div>


                @endforelse

            </div>


            {{-- =====================================================
                PAGINATION
            ===================================================== --}}
            @if($smartBuys->hasPages())

                <div class="smart-buy-admin-pagination">

                    {{ $smartBuys->links() }}

                </div>

            @endif


        </div>

    </div>

@endsection


@push('scripts')

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const selects = document.querySelectorAll(
                '.smart-buy-admin-filter-select select'
            );

            selects.forEach(function (select) {

                select.addEventListener('change', function () {

                    /*
                    |--------------------------------------------------------------------------
                    | Optional:
                    | Automatically submit filter form
                    |--------------------------------------------------------------------------
                    */

                    // this.form.submit();

                });

            });

        });

    </script>

@endpush
