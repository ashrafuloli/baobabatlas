@extends('frontend.layouts.frontend')

@section('contents')

    <div class="my-orders-page">

        <div class="container">

            {{-- Breadcrumb --}}
            <div class="my-orders-page__breadcrumb">
                <a href="{{ url('/') }}">Shop</a>
                <i class="ri-arrow-right-s-line"></i>
                <span>My Orders</span>
            </div>


            {{-- Page Header --}}
            <div class="my-orders-page__header">

                <div class="my-orders-page__header-content">
                    <span class="my-orders-page__eyebrow">
                        ORDER HISTORY
                    </span>

                    <h1 class="my-orders-page__title">
                        My Orders
                    </h1>

                    <p class="my-orders-page__subtitle">
                        Track and manage your recent orders.
                    </p>
                </div>

                <a href="{{ url('/shop') }}" class="my-orders-page__shop-btn">
                    <i class="ri-arrow-left-line"></i>
                    Continue Shopping
                </a>

            </div>


            {{-- Order Controls --}}
            <div class="my-orders-page__controls">

                <div class="my-orders-page__search">

                    <i class="ri-search-line"></i>

                    <input
                        type="search"
                        class="my-orders-page__search-input"
                        placeholder="Search orders..."
                        aria-label="Search orders"
                    >

                </div>


                <div class="my-orders-page__filter">

                    <div class="my-orders-page__status-filter">

                        <div class="status-select">

                            <button
                                type="button"
                                class="status-select-trigger"
                                aria-expanded="false"
                            >
            <span class="status-select-value">
                <span class="status-label">Status:</span>
                <strong>All Orders</strong>
            </span>

                                <i class="ri-arrow-down-s-line"></i>
                            </button>

                            <div class="status-select-options">

                                <button
                                    type="button"
                                    class="status-option is-selected"
                                    data-value="all"
                                >
                                    All Orders
                                </button>

                                <button
                                    type="button"
                                    class="status-option"
                                    data-value="pending"
                                >
                                    Pending
                                </button>

                                <button
                                    type="button"
                                    class="status-option"
                                    data-value="processing"
                                >
                                    Processing
                                </button>

                                <button
                                    type="button"
                                    class="status-option"
                                    data-value="shipped"
                                >
                                    Shipped
                                </button>

                                <button
                                    type="button"
                                    class="status-option"
                                    data-value="delivered"
                                >
                                    Delivered
                                </button>

                                <button
                                    type="button"
                                    class="status-option"
                                    data-value="cancelled"
                                >
                                    Cancelled
                                </button>

                            </div>

                            <input
                                type="hidden"
                                name="status"
                                value="all"
                                id="order-status-filter"
                                class="status-input"
                            >

                        </div>

                    </div>

                </div>

            </div>


            {{-- Orders --}}
            <div class="my-orders-page__content">

                <div class="my-orders-page__orders-header">

                    <div>
                        <span class="my-orders-page__section-label">
                            YOUR ORDERS
                        </span>

                        <h2>
                            Recent Orders
                        </h2>
                    </div>

                    <span class="my-orders-page__order-count">
                        4 Orders
                    </span>

                </div>


                <div class="my-orders-page__order-list">


                    {{-- Order 1 --}}
                    <article
                        class="my-orders-page__order-card"
                        data-status="delivered"
                        data-order="ORD-1001"
                    >

                        <div class="my-orders-page__order-top">

                            <div class="my-orders-page__order-info">

                                <div class="my-orders-page__order-number">
                                    <span>Order</span>
                                    <strong>#ORD-1001</strong>
                                </div>

                                <span class="my-orders-page__order-date">
                                    September 2, 2026
                                </span>

                            </div>

                            <span class="my-orders-page__status my-orders-page__status--delivered">
                                <i class="ri-checkbox-circle-fill"></i>
                                Delivered
                            </span>

                        </div>


                        <div class="my-orders-page__order-body">

                            <div class="my-orders-page__product-list">

                                <div class="my-orders-page__product">

                                    <div class="my-orders-page__product-image">
                                        <span>120 × 140</span>
                                    </div>

                                    <div class="my-orders-page__product-info">

                                        <span class="my-orders-page__product-category">
                                            Clothing
                                        </span>

                                        <h3>
                                            Premium Cotton T-Shirt
                                        </h3>

                                        <div class="my-orders-page__product-meta">
                                            <span>Size: M</span>
                                            <span>Color: Black</span>
                                            <span>Qty: 1</span>
                                        </div>

                                    </div>

                                    <strong class="my-orders-page__product-price">
                                        $29.99
                                    </strong>

                                </div>


                                <div class="my-orders-page__product">

                                    <div class="my-orders-page__product-image">
                                        <span>120 × 140</span>
                                    </div>

                                    <div class="my-orders-page__product-info">

                                        <span class="my-orders-page__product-category">
                                            Bags
                                        </span>

                                        <h3>
                                            Everyday Backpack
                                        </h3>

                                        <div class="my-orders-page__product-meta">
                                            <span>Color: Black</span>
                                            <span>Material: Canvas</span>
                                            <span>Qty: 1</span>
                                        </div>

                                    </div>

                                    <strong class="my-orders-page__product-price">
                                        $54.99
                                    </strong>

                                </div>

                            </div>


                            <div class="my-orders-page__order-summary">

                                <span>
                                    2 Items
                                </span>

                                <strong>
                                    $84.98
                                </strong>

                            </div>

                        </div>


                        <div class="my-orders-page__order-footer">

                            <span class="my-orders-page__delivery">
                                <i class="ri-map-pin-line"></i>
                                Delivered on Sep 4, 2026
                            </span>

                            <a href="#" class="my-orders-page__details-btn">
                                View Details
                                <i class="ri-arrow-right-line"></i>
                            </a>

                        </div>

                    </article>


                    {{-- Order 2 --}}
                    <article
                        class="my-orders-page__order-card"
                        data-status="shipped"
                        data-order="ORD-1002"
                    >

                        <div class="my-orders-page__order-top">

                            <div class="my-orders-page__order-info">

                                <div class="my-orders-page__order-number">
                                    <span>Order</span>
                                    <strong>#ORD-1002</strong>
                                </div>

                                <span class="my-orders-page__order-date">
                                    August 30, 2026
                                </span>

                            </div>

                            <span class="my-orders-page__status my-orders-page__status--shipped">
                                <i class="ri-truck-line"></i>
                                Shipped
                            </span>

                        </div>


                        <div class="my-orders-page__order-body">

                            <div class="my-orders-page__product-list">

                                <div class="my-orders-page__product">

                                    <div class="my-orders-page__product-image">
                                        <span>120 × 140</span>
                                    </div>

                                    <div class="my-orders-page__product-info">

                                        <span class="my-orders-page__product-category">
                                            Accessories
                                        </span>

                                        <h3>
                                            Classic Leather Wallet
                                        </h3>

                                        <div class="my-orders-page__product-meta">
                                            <span>Color: Brown</span>
                                            <span>Material: Leather</span>
                                            <span>Qty: 1</span>
                                        </div>

                                    </div>

                                    <strong class="my-orders-page__product-price">
                                        $49.99
                                    </strong>

                                </div>

                            </div>


                            <div class="my-orders-page__order-summary">

                                <span>
                                    1 Item
                                </span>

                                <strong>
                                    $49.99
                                </strong>

                            </div>

                        </div>


                        <div class="my-orders-page__order-footer">

                            <span class="my-orders-page__delivery">
                                <i class="ri-truck-line"></i>
                                Expected delivery Sep 5–7
                            </span>

                            <a href="#" class="my-orders-page__details-btn">
                                View Details
                                <i class="ri-arrow-right-line"></i>
                            </a>

                        </div>

                    </article>


                    {{-- Order 3 --}}
                    <article
                        class="my-orders-page__order-card"
                        data-status="processing"
                        data-order="ORD-1003"
                    >

                        <div class="my-orders-page__order-top">

                            <div class="my-orders-page__order-info">

                                <div class="my-orders-page__order-number">
                                    <span>Order</span>
                                    <strong>#ORD-1003</strong>
                                </div>

                                <span class="my-orders-page__order-date">
                                    August 28, 2026
                                </span>

                            </div>

                            <span class="my-orders-page__status my-orders-page__status--processing">
                                <i class="ri-loader-4-line"></i>
                                Processing
                            </span>

                        </div>


                        <div class="my-orders-page__order-body">

                            <div class="my-orders-page__product-list">

                                <div class="my-orders-page__product">

                                    <div class="my-orders-page__product-image">
                                        <span>120 × 140</span>
                                    </div>

                                    <div class="my-orders-page__product-info">

                                        <span class="my-orders-page__product-category">
                                            Home & Living
                                        </span>

                                        <h3>
                                            Classic Ceramic Mug
                                        </h3>

                                        <div class="my-orders-page__product-meta">
                                            <span>Color: White</span>
                                            <span>Capacity: 350ml</span>
                                            <span>Qty: 2</span>
                                        </div>

                                    </div>

                                    <strong class="my-orders-page__product-price">
                                        $39.98
                                    </strong>

                                </div>

                            </div>


                            <div class="my-orders-page__order-summary">

                                <span>
                                    2 Items
                                </span>

                                <strong>
                                    $39.98
                                </strong>

                            </div>

                        </div>


                        <div class="my-orders-page__order-footer">

                            <span class="my-orders-page__delivery">
                                <i class="ri-time-line"></i>
                                Preparing your order
                            </span>

                            <a href="#" class="my-orders-page__details-btn">
                                View Details
                                <i class="ri-arrow-right-line"></i>
                            </a>

                        </div>

                    </article>


                    {{-- Order 4 --}}
                    <article
                        class="my-orders-page__order-card"
                        data-status="cancelled"
                        data-order="ORD-1004"
                    >

                        <div class="my-orders-page__order-top">

                            <div class="my-orders-page__order-info">

                                <div class="my-orders-page__order-number">
                                    <span>Order</span>
                                    <strong>#ORD-1004</strong>
                                </div>

                                <span class="my-orders-page__order-date">
                                    August 20, 2026
                                </span>

                            </div>

                            <span class="my-orders-page__status my-orders-page__status--cancelled">
                                <i class="ri-close-circle-line"></i>
                                Cancelled
                            </span>

                        </div>


                        <div class="my-orders-page__order-body">

                            <div class="my-orders-page__product-list">

                                <div class="my-orders-page__product">

                                    <div class="my-orders-page__product-image">
                                        <span>120 × 140</span>
                                    </div>

                                    <div class="my-orders-page__product-info">

                                        <span class="my-orders-page__product-category">
                                            Electronics
                                        </span>

                                        <h3>
                                            Wireless Bluetooth Speaker
                                        </h3>

                                        <div class="my-orders-page__product-meta">
                                            <span>Color: Black</span>
                                            <span>Qty: 1</span>
                                        </div>

                                    </div>

                                    <strong class="my-orders-page__product-price">
                                        $64.99
                                    </strong>

                                </div>

                            </div>


                            <div class="my-orders-page__order-summary">

                                <span>
                                    1 Item
                                </span>

                                <strong>
                                    $64.99
                                </strong>

                            </div>

                        </div>


                        <div class="my-orders-page__order-footer">

                            <span class="my-orders-page__delivery">
                                <i class="ri-close-circle-line"></i>
                                Order cancelled
                            </span>

                            <a href="#" class="my-orders-page__details-btn">
                                View Details
                                <i class="ri-arrow-right-line"></i>
                            </a>

                        </div>

                    </article>


                    {{-- Empty Search / Filter State --}}
                    <div class="my-orders-page__empty" hidden>

                        <div class="my-orders-page__empty-icon">
                            <i class="ri-file-list-3-line"></i>
                        </div>

                        <h3>
                            No orders found
                        </h3>

                        <p>
                            Try changing your search or order status filter.
                        </p>

                        <button type="button" class="my-orders-page__reset-btn">
                            Clear Filters
                        </button>

                    </div>

                </div>

            </div>


            {{-- Bottom Shopping CTA --}}
            <div class="my-orders-page__bottom-cta">

                <div>
                    <span>
                        Looking for something new?
                    </span>

                    <strong>
                        Explore our latest products.
                    </strong>
                </div>

                <a href="{{ url('/shop') }}">
                    Browse Products
                    <i class="ri-arrow-right-line"></i>
                </a>

            </div>

        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const ordersPage =
                document.querySelector('.my-orders-page');


            if (!ordersPage) {
                return;
            }


            /*
            =====================================
                Elements
            =====================================
            */

            const searchInput =
                ordersPage.querySelector(
                    '.my-orders-page__search-input'
                );


            const statusSelect =
                ordersPage.querySelector(
                    '.status-select'
                );


            const statusTrigger =
                statusSelect
                    ? statusSelect.querySelector(
                        '.status-select-trigger'
                    )
                    : null;


            const statusOptions =
                statusSelect
                    ? statusSelect.querySelectorAll(
                        '.status-option'
                    )
                    : [];


            const statusValue =
                statusSelect
                    ? statusSelect.querySelector(
                        '.status-select-value strong'
                    )
                    : null;


            const statusInput =
                statusSelect
                    ? statusSelect.querySelector(
                        '.status-input'
                    )
                    : null;


            const orderCards =
                Array.from(
                    ordersPage.querySelectorAll(
                        '.my-orders-page__order-card'
                    )
                );


            const emptyState =
                ordersPage.querySelector(
                    '.my-orders-page__empty'
                );


            const resetButton =
                ordersPage.querySelector(
                    '.my-orders-page__reset-btn'
                );


            /*
            =====================================
                Filter Orders
            =====================================
            */

            const filterOrders = function () {

                const searchValue =
                    searchInput
                        ? searchInput.value
                            .trim()
                            .toLowerCase()
                        : '';


                const selectedStatus =
                    statusInput
                        ? statusInput.value
                        : 'all';


                let visibleOrders = 0;


                orderCards.forEach(function (orderCard) {

                    const orderNumber =
                        (
                            orderCard.dataset.order || ''
                        ).toLowerCase();


                    const orderText =
                        orderCard.textContent
                            .toLowerCase();


                    const orderStatus =
                        (
                            orderCard.dataset.status || ''
                        ).toLowerCase();


                    const matchesSearch =
                        !searchValue ||
                        orderNumber.includes(searchValue) ||
                        orderText.includes(searchValue);


                    const matchesStatus =
                        selectedStatus === 'all' ||
                        orderStatus === selectedStatus;


                    const shouldShow =
                        matchesSearch &&
                        matchesStatus;


                    orderCard.hidden =
                        !shouldShow;


                    if (shouldShow) {
                        visibleOrders++;
                    }

                });


                /*
                =====================================
                    Empty State
                =====================================
                */

                if (emptyState) {

                    emptyState.hidden =
                        visibleOrders !== 0;

                }

            };


            /*
            =====================================
                Search
            =====================================
            */

            if (searchInput) {

                searchInput.addEventListener(
                    'input',
                    filterOrders
                );

            }


            /*
            =====================================
                Custom Status Dropdown
            =====================================
            */

            if (
                statusSelect &&
                statusTrigger
            ) {

                /*
                Open / Close
                */

                statusTrigger.addEventListener(
                    'click',
                    function (event) {

                        event.stopPropagation();


                        const isOpen =
                            statusSelect.classList.contains(
                                'is-open'
                            );


                        statusSelect.classList.toggle(
                            'is-open',
                            !isOpen
                        );


                        statusTrigger.setAttribute(
                            'aria-expanded',
                            !isOpen
                                ? 'true'
                                : 'false'
                        );

                    }
                );


                /*
                Select Status
                */

                statusOptions.forEach(
                    function (option) {

                        option.addEventListener(
                            'click',
                            function (event) {

                                event.stopPropagation();


                                const value =
                                    option.dataset.value || 'all';


                                const text =
                                    option.textContent.trim();


                                /*
                                Update visible value
                                */

                                if (statusValue) {

                                    statusValue.textContent =
                                        text;

                                }


                                /*
                                Update hidden input
                                */

                                if (statusInput) {

                                    statusInput.value =
                                        value;

                                }


                                /*
                                Update selected state
                                */

                                statusOptions.forEach(
                                    function (item) {

                                        item.classList.remove(
                                            'is-selected'
                                        );

                                    }
                                );


                                option.classList.add(
                                    'is-selected'
                                );


                                /*
                                Close dropdown
                                */

                                statusSelect.classList.remove(
                                    'is-open'
                                );


                                statusTrigger.setAttribute(
                                    'aria-expanded',
                                    'false'
                                );


                                /*
                                Filter orders
                                */

                                filterOrders();

                            }
                        );

                    }
                );

            }


            /*
            =====================================
                Close Dropdown Outside
            =====================================
            */

            document.addEventListener(
                'click',
                function (event) {

                    if (
                        statusSelect &&
                        !statusSelect.contains(
                            event.target
                        )
                    ) {

                        statusSelect.classList.remove(
                            'is-open'
                        );


                        if (statusTrigger) {

                            statusTrigger.setAttribute(
                                'aria-expanded',
                                'false'
                            );

                        }

                    }

                }
            );


            /*
            =====================================
                Reset Filters
            =====================================
            */

            if (resetButton) {

                resetButton.addEventListener(
                    'click',
                    function () {

                        /*
                        Reset Search
                        */

                        if (searchInput) {

                            searchInput.value = '';

                        }


                        /*
                        Reset Status
                        */

                        if (statusInput) {

                            statusInput.value = 'all';

                        }


                        /*
                        Reset visible status text
                        */

                        if (statusValue) {

                            statusValue.textContent =
                                'All Orders';

                        }


                        /*
                        Reset selected option
                        */

                        statusOptions.forEach(
                            function (option) {

                                option.classList.remove(
                                    'is-selected'
                                );

                            }
                        );


                        const allOrdersOption =
                            statusSelect
                                ? statusSelect.querySelector(
                                    '.status-option[data-value="all"]'
                                )
                                : null;


                        if (allOrdersOption) {

                            allOrdersOption.classList.add(
                                'is-selected'
                            );

                        }


                        /*
                        Close dropdown
                        */

                        if (statusSelect) {

                            statusSelect.classList.remove(
                                'is-open'
                            );

                        }


                        if (statusTrigger) {

                            statusTrigger.setAttribute(
                                'aria-expanded',
                                'false'
                            );

                        }


                        /*
                        Apply reset
                        */

                        filterOrders();

                    }
                );

            }


            /*
            =====================================
                Initial Filter
            =====================================
            */

            filterOrders();

        });
    </script>

@endsection
