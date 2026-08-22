@extends('backend.layouts.backend')

@section('title', 'My Orders')

@section('content')

    <div class="customer-orders-page">

        {{-- ================================================================ --}}
        {{-- HEADER --}}
        {{-- ================================================================ --}}

        <div class="customer-orders-header">

            <div>
            <span class="customer-orders-header__eyebrow">
                Account
            </span>

                <h1>
                    My Orders
                </h1>

                <p>
                    View and manage your recent orders.
                </p>
            </div>

            <a
                href="{{ route('customer-shop') }}"
                class="customer-orders-header__shop"
            >
                <i class="ri-shopping-bag-3-line"></i>
                Continue Shopping
            </a>

        </div>


        {{-- ================================================================ --}}
        {{-- ORDER SUMMARY --}}
        {{-- ================================================================ --}}

        <div class="customer-orders-summary">

            <div class="customer-orders-summary__card">

                <div class="customer-orders-summary__icon">
                    <i class="ri-shopping-bag-3-line"></i>
                </div>

                <div>
                <span>
                    Total Orders
                </span>

                    <strong>
                        12
                    </strong>
                </div>

            </div>


            <div class="customer-orders-summary__card">

                <div class="customer-orders-summary__icon">
                    <i class="ri-time-line"></i>
                </div>

                <div>
                <span>
                    Processing
                </span>

                    <strong>
                        2
                    </strong>
                </div>

            </div>


            <div class="customer-orders-summary__card">

                <div class="customer-orders-summary__icon">
                    <i class="ri-truck-line"></i>
                </div>

                <div>
                <span>
                    Shipped
                </span>

                    <strong>
                        3
                    </strong>
                </div>

            </div>


            <div class="customer-orders-summary__card">

                <div class="customer-orders-summary__icon">
                    <i class="ri-checkbox-circle-line"></i>
                </div>

                <div>
                <span>
                    Delivered
                </span>

                    <strong>
                        7
                    </strong>
                </div>

            </div>

        </div>


        {{-- ================================================================ --}}
        {{-- ORDERS CARD --}}
        {{-- ================================================================ --}}

        <div class="customer-orders-card">


            {{-- ============================================================ --}}
            {{-- TOOLBAR --}}
            {{-- ============================================================ --}}

            <div class="customer-orders-toolbar">

                <div class="customer-orders-tabs">

                    <button
                        type="button"
                        class="customer-orders-tab active"
                        data-order-filter="all"
                    >
                        All Orders
                        <span>12</span>
                    </button>

                    <button
                        type="button"
                        class="customer-orders-tab"
                        data-order-filter="processing"
                    >
                        Processing
                        <span>2</span>
                    </button>

                    <button
                        type="button"
                        class="customer-orders-tab"
                        data-order-filter="shipped"
                    >
                        Shipped
                        <span>3</span>
                    </button>

                    <button
                        type="button"
                        class="customer-orders-tab"
                        data-order-filter="delivered"
                    >
                        Delivered
                        <span>7</span>
                    </button>

                </div>


                <div class="customer-orders-search">

                    <i class="ri-search-line"></i>

                    <input
                        type="search"
                        placeholder="Search orders..."
                        aria-label="Search orders"
                        data-order-search
                    >

                </div>

            </div>


            {{-- ============================================================ --}}
            {{-- ORDER LIST --}}
            {{-- ============================================================ --}}

            <div class="customer-orders-list" data-orders-list>


                {{-- ======================================================== --}}
                {{-- ORDER 1 --}}
                {{-- ======================================================== --}}

                <article
                    class="customer-order-item"
                    data-order-status="delivered"
                    data-order-search="ORD-2026-001 Premium Cotton T-Shirt Everyday Backpack"
                >

                    <div class="customer-order-item__top">

                        <div class="customer-order-item__number">

                        <span>
                            Order Number
                        </span>

                            <strong>
                                #ORD-2026-001
                            </strong>

                        </div>


                        <span class="customer-order-status delivered">
                        <i class="ri-checkbox-circle-fill"></i>
                        Delivered
                    </span>

                    </div>


                    <div class="customer-order-item__body">


                        <div class="customer-order-products">

                            <div class="customer-order-product">

                                <div class="customer-order-product__image">

                                    <img
                                        src="https://placehold.co/100x115"
                                        alt="Premium Cotton T-Shirt"
                                    >

                                </div>

                                <div class="customer-order-product__info">

                                    <strong>
                                        Premium Cotton T-Shirt
                                    </strong>

                                    <span>
                                    Black / M
                                </span>

                                    <small>
                                        Qty: 1
                                    </small>

                                </div>

                            </div>


                            <div class="customer-order-product">

                                <div class="customer-order-product__image">

                                    <img
                                        src="https://placehold.co/100x115"
                                        alt="Everyday Backpack"
                                    >

                                </div>

                                <div class="customer-order-product__info">

                                    <strong>
                                        Everyday Backpack
                                    </strong>

                                    <span>
                                    Black
                                </span>

                                    <small>
                                        Qty: 1
                                    </small>

                                </div>

                            </div>

                        </div>


                        <div class="customer-order-item__meta">

                            <div>

                            <span>
                                Order Date
                            </span>

                                <strong>
                                    Aug 12, 2026
                                </strong>

                            </div>

                            <div>

                            <span>
                                Total
                            </span>

                                <strong>
                                    $84.98
                                </strong>

                            </div>

                            <div>

                            <span>
                                Payment
                            </span>

                                <strong>
                                    Paid
                                </strong>

                            </div>

                        </div>

                    </div>


                    <div class="customer-order-item__actions">

                        <a
                            href="{{ route('order-details', ['order' => 1]) }}"
                            class="customer-order-action primary"
                        >
                            View Details
                            <i class="ri-arrow-right-line"></i>
                        </a>

                        <a
                            href="{{ route('ecommerce-shipment', ['order' => 1]) }}"
                            class="customer-order-action"
                        >
                            <i class="ri-truck-line"></i>
                            Shipment
                        </a>

                        <a
                            href="{{ route('ecommerce-tracking', ['order' => 1]) }}"
                            class="customer-order-action"
                        >
                            <i class="ri-map-pin-line"></i>
                            Track Order
                        </a>

                    </div>

                </article>


                {{-- ======================================================== --}}
                {{-- ORDER 2 --}}
                {{-- ======================================================== --}}

                <article
                    class="customer-order-item"
                    data-order-status="shipped"
                    data-order-search="ORD-2026-002 Classic Leather Wallet"
                >

                    <div class="customer-order-item__top">

                        <div class="customer-order-item__number">

                        <span>
                            Order Number
                        </span>

                            <strong>
                                #ORD-2026-002
                            </strong>

                        </div>


                        <span class="customer-order-status shipped">
                        <i class="ri-truck-fill"></i>
                        Shipped
                    </span>

                    </div>


                    <div class="customer-order-item__body">

                        <div class="customer-order-products">

                            <div class="customer-order-product">

                                <div class="customer-order-product__image">

                                    <img
                                        src="https://placehold.co/100x115"
                                        alt="Classic Leather Wallet"
                                    >

                                </div>

                                <div class="customer-order-product__info">

                                    <strong>
                                        Classic Leather Wallet
                                    </strong>

                                    <span>
                                    Brown
                                </span>

                                    <small>
                                        Qty: 1
                                    </small>

                                </div>

                            </div>

                        </div>


                        <div class="customer-order-item__meta">

                            <div>

                            <span>
                                Order Date
                            </span>

                                <strong>
                                    Aug 10, 2026
                                </strong>

                            </div>

                            <div>

                            <span>
                                Total
                            </span>

                                <strong>
                                    $49.99
                                </strong>

                            </div>

                            <div>

                            <span>
                                Payment
                            </span>

                                <strong>
                                    Paid
                                </strong>

                            </div>

                        </div>

                    </div>


                    <div class="customer-order-item__actions">

                        <a
                            href="{{ route('order-details', ['order' => 2]) }}"
                            class="customer-order-action primary"
                        >
                            View Details
                            <i class="ri-arrow-right-line"></i>
                        </a>

                        <a
                            href="{{ route('ecommerce-shipment', ['order' => 2]) }}"
                            class="customer-order-action"
                        >
                            <i class="ri-truck-line"></i>
                            Shipment
                        </a>

                        <a
                            href="{{ route('ecommerce-tracking', ['order' => 2]) }}"
                            class="customer-order-action"
                        >
                            <i class="ri-map-pin-line"></i>
                            Track Order
                        </a>

                    </div>

                </article>


                {{-- ======================================================== --}}
                {{-- ORDER 3 --}}
                {{-- ======================================================== --}}

                <article
                    class="customer-order-item"
                    data-order-status="processing"
                    data-order-search="ORD-2026-003 Oversized Hoodie Daily Face Moisturizer"
                >

                    <div class="customer-order-item__top">

                        <div class="customer-order-item__number">

                        <span>
                            Order Number
                        </span>

                            <strong>
                                #ORD-2026-003
                            </strong>

                        </div>


                        <span class="customer-order-status processing">
                        <i class="ri-time-fill"></i>
                        Processing
                    </span>

                    </div>


                    <div class="customer-order-item__body">

                        <div class="customer-order-products">

                            <div class="customer-order-product">

                                <div class="customer-order-product__image">

                                    <img
                                        src="https://placehold.co/100x115"
                                        alt="Oversized Hoodie"
                                    >

                                </div>

                                <div class="customer-order-product__info">

                                    <strong>
                                        Oversized Hoodie
                                    </strong>

                                    <span>
                                    Gray / L
                                </span>

                                    <small>
                                        Qty: 1
                                    </small>

                                </div>

                            </div>


                            <div class="customer-order-product">

                                <div class="customer-order-product__image">

                                    <img
                                        src="https://placehold.co/100x115"
                                        alt="Daily Face Moisturizer"
                                    >

                                </div>

                                <div class="customer-order-product__info">

                                    <strong>
                                        Daily Face Moisturizer
                                    </strong>

                                    <span>
                                    150ml
                                </span>

                                    <small>
                                        Qty: 2
                                    </small>

                                </div>

                            </div>

                        </div>


                        <div class="customer-order-item__meta">

                            <div>

                            <span>
                                Order Date
                            </span>

                                <strong>
                                    Aug 15, 2026
                                </strong>

                            </div>

                            <div>

                            <span>
                                Total
                            </span>

                                <strong>
                                    $99.97
                                </strong>

                            </div>

                            <div>

                            <span>
                                Payment
                            </span>

                                <strong>
                                    Paid
                                </strong>

                            </div>

                        </div>

                    </div>


                    <div class="customer-order-item__actions">

                        <a
                            href="{{ route('order-details', ['order' => 3]) }}"
                            class="customer-order-action primary"
                        >
                            View Details
                            <i class="ri-arrow-right-line"></i>
                        </a>

                    </div>

                </article>


                {{-- ======================================================== --}}
                {{-- ORDER 4 --}}
                {{-- ======================================================== --}}

                <article
                    class="customer-order-item"
                    data-order-status="delivered"
                    data-order-search="ORD-2026-004 Running Shoes"
                >

                    <div class="customer-order-item__top">

                        <div class="customer-order-item__number">

                        <span>
                            Order Number
                        </span>

                            <strong>
                                #ORD-2026-004
                            </strong>

                        </div>


                        <span class="customer-order-status delivered">
                        <i class="ri-checkbox-circle-fill"></i>
                        Delivered
                    </span>

                    </div>


                    <div class="customer-order-item__body">

                        <div class="customer-order-products">

                            <div class="customer-order-product">

                                <div class="customer-order-product__image">

                                    <img
                                        src="https://placehold.co/100x115"
                                        alt="Running Shoes"
                                    >

                                </div>

                                <div class="customer-order-product__info">

                                    <strong>
                                        Running Shoes
                                    </strong>

                                    <span>
                                    White / 42
                                </span>

                                    <small>
                                        Qty: 1
                                    </small>

                                </div>

                            </div>

                        </div>


                        <div class="customer-order-item__meta">

                            <div>

                            <span>
                                Order Date
                            </span>

                                <strong>
                                    Aug 06, 2026
                                </strong>

                            </div>

                            <div>

                            <span>
                                Total
                            </span>

                                <strong>
                                    $79.99
                                </strong>

                            </div>

                            <div>

                            <span>
                                Payment
                            </span>

                                <strong>
                                    Paid
                                </strong>

                            </div>

                        </div>

                    </div>


                    <div class="customer-order-item__actions">

                        <a
                            href="{{ route('order-details', ['order' => 4]) }}"
                            class="customer-order-action primary"
                        >
                            View Details
                            <i class="ri-arrow-right-line"></i>
                        </a>

                        <a
                            href="{{ route('ecommerce-shipment', ['order' => 4]) }}"
                            class="customer-order-action"
                        >
                            <i class="ri-truck-line"></i>
                            Shipment
                        </a>

                        <a
                            href="{{ route('ecommerce-tracking', ['order' => 4]) }}"
                            class="customer-order-action"
                        >
                            <i class="ri-map-pin-line"></i>
                            Track Order
                        </a>

                    </div>

                </article>


            </div>


            {{-- ============================================================ --}}
            {{-- EMPTY STATE --}}
            {{-- ============================================================ --}}

            <div
                class="customer-orders-empty"
                data-orders-empty
                hidden
            >

                <div class="customer-orders-empty__icon">
                    <i class="ri-shopping-bag-3-line"></i>
                </div>

                <h2>
                    No Orders Found
                </h2>

                <p>
                    We couldn't find any orders matching your search.
                </p>

                <button
                    type="button"
                    data-clear-order-search
                >
                    Clear Search
                </button>

            </div>


            {{-- ============================================================ --}}
            {{-- PAGINATION --}}
            {{-- ============================================================ --}}

            <div class="customer-orders-pagination">

                <button
                    type="button"
                    disabled
                    aria-label="Previous page"
                >
                    <i class="ri-arrow-left-s-line"></i>
                </button>

                <button
                    type="button"
                    class="active"
                >
                    1
                </button>

                <button type="button">
                    2
                </button>

                <button type="button">
                    3
                </button>

                <span>
                ...
            </span>

                <button type="button">
                    6
                </button>

                <button
                    type="button"
                    aria-label="Next page"
                >
                    <i class="ri-arrow-right-s-line"></i>
                </button>

            </div>

        </div>

    </div>


    @push('scripts')

        <script>

            document.addEventListener('DOMContentLoaded', function () {

                const tabs =
                    document.querySelectorAll(
                        '[data-order-filter]'
                    );

                const orders =
                    document.querySelectorAll(
                        '[data-order-status]'
                    );

                const search =
                    document.querySelector(
                        '[data-order-search]'
                    );

                const empty =
                    document.querySelector(
                        '[data-orders-empty]'
                    );

                const clearSearch =
                    document.querySelector(
                        '[data-clear-order-search]'
                    );


                let currentFilter = 'all';


                function filterOrders() {

                    const searchValue =
                        search
                            ? search.value
                                .trim()
                                .toLowerCase()
                            : '';

                    let visibleCount = 0;


                    orders.forEach(function (order) {

                        const status =
                            order.dataset.orderStatus;

                        const searchableText =
                            order.dataset.orderSearch
                                ? order.dataset.orderSearch
                                    .toLowerCase()
                                : order.textContent
                                    .toLowerCase();


                        const matchesFilter =
                            currentFilter === 'all' ||
                            status === currentFilter;


                        const matchesSearch =
                            !searchValue ||
                            searchableText.includes(
                                searchValue
                            );


                        const visible =
                            matchesFilter &&
                            matchesSearch;


                        order.hidden = !visible;


                        if (visible) {
                            visibleCount++;
                        }

                    });


                    if (empty) {
                        empty.hidden =
                            visibleCount !== 0;
                    }

                }


                tabs.forEach(function (tab) {

                    tab.addEventListener(
                        'click',
                        function () {

                            currentFilter =
                                tab.dataset.orderFilter;


                            tabs.forEach(function (item) {

                                item.classList.remove(
                                    'active'
                                );

                            });


                            tab.classList.add(
                                'active'
                            );


                            filterOrders();

                        }
                    );

                });


                if (search) {

                    search.addEventListener(
                        'input',
                        filterOrders
                    );

                }


                if (clearSearch) {

                    clearSearch.addEventListener(
                        'click',
                        function () {

                            if (search) {
                                search.value = '';
                            }

                            currentFilter = 'all';


                            tabs.forEach(function (tab) {

                                tab.classList.toggle(
                                    'active',
                                    tab.dataset.orderFilter === 'all'
                                );

                            });


                            filterOrders();

                        }
                    );

                }


                filterOrders();

            });

        </script>

    @endpush

@endsection
