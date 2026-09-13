@extends('frontend.layouts.frontend')

@section('contents')

    @php
        $cartItems = $cart->items;

        $cartQuantity = $cartItems->sum('quantity');

        /*
        |--------------------------------------------------------------------------
        | Subtotal
        |--------------------------------------------------------------------------
        */

        $subtotal = $cartItems->sum(function ($cartItem) {
            $unitPrice = $cartItem->variant
                ? $cartItem->variant->price
                : $cartItem->product->price;

            return (float) $unitPrice * $cartItem->quantity;
        });

        /*
        |--------------------------------------------------------------------------
        | Product Shipping
        |--------------------------------------------------------------------------
        |
        | Shipping cost is product-level.
        |
        | Each cart line contributes its product shipping cost once.
        | Quantity does NOT multiply the shipping cost.
        |
        */

        $shipping = $cartItems->sum(function ($cartItem) {
            return (float) ($cartItem->product->shipping_cost ?? 0);
        });

        $discount = (float) ($discount ?? 0);
        $tax = (float) ($tax ?? 0);

        $total = max(
            0,
            $subtotal + $shipping + $tax - $discount
        );

        $appliedCoupon = $appliedCoupon ?? null;
    @endphp

    <section class="shopping-cart-page section-padding">

        <div class="container">

            {{-- ============================================================
                Breadcrumb
            ============================================================= --}}

            <div class="cart-breadcrumb">

                <a href="{{ route('shop') }}">
                    Shop
                </a>

                <span>
                    <i class="ri-arrow-right-s-line"></i>
                </span>

                <span>
                    Cart
                </span>

            </div>


            {{-- ============================================================
                Page Header
            ============================================================= --}}

            <div class="cart-page-header">

                <div class="cart-page-header__content">

                    <span class="section-subtitle">
                        SHOPPING CART
                    </span>

                    <h1>
                        Your Cart
                    </h1>

                    <p>
                        Review your items before proceeding to checkout.
                    </p>

                </div>


                <a
                    href="{{ route('shop') }}"
                    class="cart-continue-btn"
                >

                    <i class="ri-arrow-left-line"></i>

                    <span>
                        Continue Shopping
                    </span>

                </a>

            </div>


            {{-- ============================================================
                Cart With Items
            ============================================================= --}}

            @if ($cartItems->isNotEmpty())

                <div class="cart-page-grid">

                    {{-- ====================================================
                        Cart Items
                    ===================================================== --}}

                    <div class="cart-items-wrapper">

                        <div class="cart-items-card">

                            {{-- =================================================
                                Cart Items Header
                            ================================================== --}}

                            <div class="cart-items-card__header">

                                <div>

                                    <span class="section-subtitle">
                                        CART ITEMS
                                    </span>

                                    <h2 class="cart-product-count">

                                        {{ $cartQuantity }}

                                        {{ $cartQuantity === 1
                                            ? 'Product'
                                            : 'Products' }}

                                    </h2>

                                </div>


                                <button
                                    type="button"
                                    class="clear-cart-btn"
                                >

                                    <i class="ri-delete-bin-line"></i>

                                    <span>
                                        Clear Cart
                                    </span>

                                </button>

                            </div>


                            {{-- =================================================
                                Cart Items List
                            ================================================== --}}

                            <div class="cart-items-list">

                                @foreach ($cartItems as $cartItem)

                                    @php
                                        $product = $cartItem->product;
                                        $variant = $cartItem->variant;

                                        /*
                                        |--------------------------------------------------------------------------
                                        | Unit Price
                                        |--------------------------------------------------------------------------
                                        */

                                        $unitPrice = $variant
                                            ? (float) $variant->price
                                            : (float) $product->price;

                                        /*
                                        |--------------------------------------------------------------------------
                                        | Item Total
                                        |--------------------------------------------------------------------------
                                        */

                                        $itemTotal =
                                            $unitPrice *
                                            $cartItem->quantity;

                                        /*
                                        |--------------------------------------------------------------------------
                                        | Product Shipping Cost
                                        |--------------------------------------------------------------------------
                                        */

                                        $itemShippingCost =
                                            (float) ($product->shipping_cost ?? 0);

                                        /*
                                        |--------------------------------------------------------------------------
                                        | Product Image
                                        |--------------------------------------------------------------------------
                                        */

                                        $productImage = null;

                                        if ($variant) {

                                            $productImage =
                                                $variant->image;

                                            if (!$productImage) {

                                                $variantImage =
                                                    $variant->images->first();

                                                if ($variantImage) {

                                                    $productImage =
                                                        $variantImage->image;

                                                }

                                            }

                                        }

                                        if (!$productImage) {

                                            $productImage =
                                                $product->images
                                                    ->whereNull('variant_id')
                                                    ->first()?->image;

                                        }

                                        if (!$productImage) {

                                            $productImage =
                                                $product->thumbnail;

                                        }

                                        $productImageUrl = $productImage
                                            ? asset($productImage)
                                            : asset(
                                                'assets/img/products/placeholder.png'
                                            );

                                        /*
                                        |--------------------------------------------------------------------------
                                        | Product URL
                                        |--------------------------------------------------------------------------
                                        */

                                        $productUrl = route(
                                            'shop.details',
                                            $product->slug
                                        );

                                        /*
                                        |--------------------------------------------------------------------------
                                        | Category
                                        |--------------------------------------------------------------------------
                                        */

                                        $category =
                                            $product->categories->first();

                                        /*
                                        |--------------------------------------------------------------------------
                                        | Availability
                                        |--------------------------------------------------------------------------
                                        */

                                        $isProductAvailable =
                                            $product->isActive();

                                        $isVariantAvailable =
                                            !$variant ||
                                            $variant->isActive();

                                        $hasStock =
                                            !$variant ||
                                            $variant->stock >=
                                            $cartItem->quantity;

                                        $isAvailable =
                                            $isProductAvailable &&
                                            $isVariantAvailable &&
                                            $hasStock;
                                    @endphp


                                    <div
                                        class="cart-item {{ !$isAvailable ? 'is-unavailable' : '' }}"
                                        data-item-id="{{ $cartItem->id }}"
                                        data-price="{{ number_format($unitPrice, 2, '.', '') }}"
                                        data-shipping-cost="{{ number_format($itemShippingCost, 2, '.', '') }}"
                                        data-update-url="{{ route('cart.items.update', $cartItem->id) }}"
                                        data-remove-url="{{ route('cart.items.destroy', $cartItem->id) }}"
                                    >

                                        {{-- ========================================
                                            Product Image
                                        ========================================= --}}

                                        <div class="cart-item__image">

                                            <a href="{{ $productUrl }}">

                                                <img
                                                    src="{{ $productImageUrl }}"
                                                    alt="{{ $product->name }}"
                                                >

                                            </a>

                                        </div>


                                        {{-- ========================================
                                            Product Content
                                        ========================================= --}}

                                        <div class="cart-item__content">

                                            {{-- Category --}}

                                            @if ($category)

                                                <span class="cart-item__category">
                                                    {{ $category->name }}
                                                </span>

                                            @endif


                                            {{-- Product Name --}}

                                            <h3>

                                                <a href="{{ $productUrl }}">
                                                    {{ $product->name }}
                                                </a>

                                            </h3>


                                            {{-- ====================================
                                                Variant / SKU
                                            ===================================== --}}

                                            @if ($variant)

                                                <div class="cart-item__meta">

                                                    @foreach ($variant->values as $variantValue)

                                                        @if (
                                                            $variantValue->attribute &&
                                                            $variantValue->attributeValue
                                                        )

                                                            <span>

                                                                <strong>
                                                                    {{ $variantValue->attribute->name }}:
                                                                </strong>

                                                                {{ $variantValue->attributeValue->label }}

                                                            </span>

                                                        @endif

                                                    @endforeach


                                                    @if ($variant->sku)

                                                        <span>

                                                            <strong>
                                                                SKU:
                                                            </strong>

                                                            {{ $variant->sku }}

                                                        </span>

                                                    @endif

                                                </div>

                                            @elseif ($product->sku)

                                                <div class="cart-item__meta">

                                                    <span>

                                                        <strong>
                                                            SKU:
                                                        </strong>

                                                        {{ $product->sku }}

                                                    </span>

                                                </div>

                                            @endif


                                            {{-- ====================================
                                                Availability
                                            ===================================== --}}

                                            @if (!$isAvailable)

                                                <div class="cart-item__availability">

                                                    @if (!$isProductAvailable)

                                                        <span>
                                                            This product is no longer available.
                                                        </span>

                                                    @elseif (!$isVariantAvailable)

                                                        <span>
                                                            This variant is no longer available.
                                                        </span>

                                                    @elseif (!$hasStock)

                                                        <span>

                                                            Only
                                                            {{ $variant->stock }}
                                                            {{ $variant->stock === 1 ? 'item' : 'items' }}
                                                            available.

                                                        </span>

                                                    @endif

                                                </div>

                                            @endif


                                            {{-- ====================================
                                                Quantity + Price
                                            ===================================== --}}

                                            <div class="cart-item__bottom">

                                                {{-- Quantity --}}

                                                <div class="quantity-control">

                                                    <button
                                                        type="button"
                                                        class="quantity-btn quantity-minus"
                                                        aria-label="Decrease quantity"
                                                        {{ !$isAvailable ? 'disabled' : '' }}
                                                    >

                                                        <i class="ri-subtract-line"></i>

                                                    </button>


                                                    <input
                                                        type="number"
                                                        class="quantity-input"
                                                        value="{{ $cartItem->quantity }}"
                                                        min="1"
                                                        max="{{ $variant ? max(1, $variant->stock) : 999 }}"
                                                        readonly
                                                        aria-label="Quantity"
                                                    >


                                                    <button
                                                        type="button"
                                                        class="quantity-btn quantity-plus"
                                                        aria-label="Increase quantity"
                                                        {{ !$isAvailable || ($variant && $cartItem->quantity >= $variant->stock) ? 'disabled' : '' }}
                                                    >

                                                        <i class="ri-add-line"></i>

                                                    </button>

                                                </div>


                                                {{-- Price --}}

                                                <div class="cart-item__price">

                                                    <span class="unit-price">

                                                        ${{ number_format($unitPrice, 2) }}
                                                        each

                                                    </span>


                                                    {{-- Product Shipping --}}

                                                    @if ($itemShippingCost > 0)

                                                        <span class="item-shipping">

                                                            Shipping:
                                                            ${{ number_format(
                                                                $itemShippingCost,
                                                                2
                                                            ) }}

                                                        </span>

                                                    @else

                                                        <span class="item-shipping">

                                                            Free Shipping

                                                        </span>

                                                    @endif


                                                    {{-- Item Total --}}

                                                    <strong class="item-total">

                                                        ${{ number_format($itemTotal, 2) }}

                                                    </strong>

                                                </div>

                                            </div>

                                        </div>


                                        {{-- ========================================
                                            Remove Item
                                        ========================================= --}}

                                        <button
                                            type="button"
                                            class="cart-item-remove"
                                            aria-label="Remove {{ $product->name }}"
                                            data-remove-url="{{ route('cart.items.destroy', $cartItem->id) }}"
                                        >

                                            <i class="ri-delete-bin-line"></i>

                                        </button>

                                    </div>

                                @endforeach

                            </div>


                            {{-- =================================================
                                Cart Footer
                            ================================================== --}}

                            <div class="cart-items-card__footer">

                                <a
                                    href="{{ route('shop') }}"
                                    class="cart-footer-continue"
                                >

                                    <i class="ri-arrow-left-line"></i>

                                    Continue Shopping

                                </a>


                                <div class="cart-secure-note">

                                    <span>
                                        Secure checkout available
                                    </span>

                                    <i class="ri-lock-line"></i>

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- ====================================================
                        Cart Sidebar
                    ===================================================== --}}

                    <aside class="cart-sidebar">

                        {{-- =================================================
                            Order Summary
                        ================================================== --}}

                        <div class="cart-summary-card">

                            <div class="cart-summary-card__header">

                                <span class="section-subtitle">
                                    ORDER SUMMARY
                                </span>

                                <h2>
                                    Cart Total
                                </h2>

                            </div>


                            {{-- =================================================
                                Promo Code
                            ================================================== --}}

                            <div class="promo-code">

                                <label for="promo-code">
                                    Have a promo code?
                                </label>


                                @if ($appliedCoupon)

                                    <div class="promo-code__applied">

                                        <div class="promo-code__applied-info">

                                            <i class="ri-coupon-3-line"></i>

                                            <span>
                                                {{ $appliedCoupon->code }}
                                            </span>

                                        </div>


                                        <button
                                            type="button"
                                            class="remove-promo-btn"
                                            aria-label="Remove promo code"
                                            title="Remove promo code"
                                        >

                                            <i class="ri-close-line"></i>

                                        </button>

                                    </div>

                                @else

                                    <div class="promo-code__field">

                                        <input
                                            type="text"
                                            id="promo-code"
                                            placeholder="Enter code"
                                            autocomplete="off"
                                            maxlength="50"
                                        >

                                        <button
                                            type="button"
                                            class="apply-promo-btn"
                                        >
                                            Apply
                                        </button>

                                    </div>

                                @endif

                            </div>


                            {{-- =================================================
                                Summary
                            ================================================== --}}

                            <div class="cart-summary-list">

                                {{-- Subtotal --}}

                                <div class="summary-row">

                                    <span>
                                        Subtotal
                                    </span>

                                    <strong class="summary-subtotal">
                                        ${{ number_format($subtotal, 2) }}
                                    </strong>

                                </div>


                                {{-- Shipping --}}

                                <div class="summary-row">

                                    <span>
                                        Shipping
                                    </span>

                                    <strong class="summary-shipping">
                                        ${{ number_format($shipping, 2) }}
                                    </strong>

                                </div>


                                {{-- Discount --}}

                                <div class="summary-row summary-discount">

                                    <span>
                                        Discount
                                    </span>

                                    <strong class="summary-discount-value">

                                        -${{ number_format(
                                            $discount,
                                            2
                                        ) }}

                                    </strong>

                                </div>


                                {{-- Tax --}}

                                <div class="summary-row">

                                    <span>
                                        Tax
                                    </span>

                                    <strong class="summary-tax">
                                        ${{ number_format($tax, 2) }}
                                    </strong>

                                </div>

                            </div>


                            {{-- =================================================
                                Total
                            ================================================== --}}

                            <div class="cart-summary-total">

                                <span>
                                    Total
                                </span>

                                <strong class="summary-total">
                                    ${{ number_format($total, 2) }}
                                </strong>

                            </div>


                            {{-- =================================================
                                Checkout
                            ================================================== --}}

                            @if ($cartItems->isNotEmpty())

                                <a
                                    href="{{ route('checkout') }}"
                                    class="checkout-btn"
                                >

                                    <span>
                                        Proceed to Checkout
                                    </span>

                                    <i class="ri-arrow-right-line"></i>

                                </a>

                            @endif


                            <div class="checkout-security">

                                <i class="ri-shield-check-line"></i>

                                <span>
                                    Secure checkout & protected payment
                                </span>

                            </div>

                        </div>


                        {{-- =================================================
                            Cart Benefits
                        ================================================== --}}

                        <div class="cart-benefits-card">

                            <div class="cart-benefit">

                                <div class="cart-benefit__icon">
                                    <i class="ri-truck-line"></i>
                                </div>

                                <div>

                                    <h4>
                                        Free Shipping
                                    </h4>

                                    <p>
                                        On orders over $50
                                    </p>

                                </div>

                            </div>


                            <div class="cart-benefit">

                                <div class="cart-benefit__icon">
                                    <i class="ri-refresh-line"></i>
                                </div>

                                <div>

                                    <h4>
                                        Easy Returns
                                    </h4>

                                    <p>
                                        30-day return policy
                                    </p>

                                </div>

                            </div>


                            <div class="cart-benefit">

                                <div class="cart-benefit__icon">
                                    <i class="ri-shield-check-line"></i>
                                </div>

                                <div>

                                    <h4>
                                        Secure Shopping
                                    </h4>

                                    <p>
                                        Your data is protected
                                    </p>

                                </div>

                            </div>

                        </div>

                    </aside>

                </div>

            @endif


            {{-- ============================================================
                Empty Cart
            ============================================================= --}}

            <div class="cart-empty-state {{ $cartItems->isEmpty() ? 'is-visible' : '' }}">

                <div class="cart-empty-state__icon">

                    <i class="ri-shopping-bag-line"></i>

                </div>


                <h2>
                    Your cart is empty
                </h2>


                <p>
                    Looks like you haven't added anything to your cart yet.
                </p>


                <a
                    href="{{ route('shop') }}"
                    class="cart-continue-btn"
                >

                    Continue Shopping

                    <i class="ri-arrow-right-line"></i>

                </a>

            </div>

        </div>

    </section>

@endsection


@push('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const cartPage =
                document.querySelector(
                    '.shopping-cart-page'
                );


            if (!cartPage) {
                return;
            }


            /*
            |--------------------------------------------------------------------------
            | CSRF
            |--------------------------------------------------------------------------
            */

            const csrfToken =
                document.querySelector(
                    'meta[name="csrf-token"]'
                )?.getAttribute(
                    'content'
                );


            /*
            |--------------------------------------------------------------------------
            | Elements
            |--------------------------------------------------------------------------
            */

            const cartProductCount =
                cartPage.querySelector(
                    '.cart-product-count'
                );


            const subtotalElement =
                cartPage.querySelector(
                    '.summary-subtotal'
                );


            const discountElement =
                cartPage.querySelector(
                    '.summary-discount-value'
                );


            const shippingElement =
                cartPage.querySelector(
                    '.summary-shipping'
                );


            const taxElement =
                cartPage.querySelector(
                    '.summary-tax'
                );


            const totalElement =
                cartPage.querySelector(
                    '.summary-total'
                );


            const clearCartButton =
                cartPage.querySelector(
                    '.clear-cart-btn'
                );


            const cartGrid =
                cartPage.querySelector(
                    '.cart-page-grid'
                );


            const emptyState =
                cartPage.querySelector(
                    '.cart-empty-state'
                );


            const checkoutButton =
                cartPage.querySelector(
                    '.checkout-btn'
                );


            const applyPromoButton =
                cartPage.querySelector(
                    '.apply-promo-btn'
                );


            const promoInput =
                cartPage.querySelector(
                    '#promo-code'
                );


            const removePromoButton =
                cartPage.querySelector(
                    '.remove-promo-btn'
                );


            /*
            |--------------------------------------------------------------------------
            | Server-side Values
            |--------------------------------------------------------------------------
            */

            const hasAppliedCoupon =
                @json($appliedCoupon !== null);


            const initialDiscount =
                Number(
                    @json($discount)
                ) || 0;


            const initialTax =
                Number(
                    @json($tax)
                ) || 0;


            /*
            |--------------------------------------------------------------------------
            | Price Formatter
            |--------------------------------------------------------------------------
            */

            const formatPrice = function (price) {

                const numericPrice =
                    Number(price);


                if (!Number.isFinite(numericPrice)) {

                    return '$0.00';

                }


                return '$' +
                    numericPrice.toLocaleString(
                        'en-US',
                        {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        }
                    );

            };


            /*
            |--------------------------------------------------------------------------
            | Generic Button Loading
            |--------------------------------------------------------------------------
            */

            const setButtonLoading = function (
                button,
                loading
            ) {

                if (!button) {
                    return;
                }


                if (loading) {

                    button.dataset.loading =
                        'true';

                    button.disabled =
                        true;

                    button.setAttribute(
                        'disabled',
                        ''
                    );

                    button.classList.add(
                        'is-loading'
                    );

                    button.setAttribute(
                        'aria-busy',
                        'true'
                    );

                    return;

                }


                button.dataset.loading =
                    'false';

                button.disabled =
                    false;

                button.removeAttribute(
                    'disabled'
                );

                button.classList.remove(
                    'is-loading'
                );

                button.removeAttribute(
                    'aria-busy'
                );

            };


            /*
            |--------------------------------------------------------------------------
            | Quantity Button Loading
            |--------------------------------------------------------------------------
            */

            const setQuantityButtonLoading = function (
                button,
                loading
            ) {

                if (!button) {
                    return;
                }


                if (loading) {

                    button.dataset.loading =
                        'true';

                    button.disabled =
                        true;

                    button.setAttribute(
                        'disabled',
                        ''
                    );

                    button.classList.add(
                        'is-loading'
                    );

                    button.setAttribute(
                        'aria-busy',
                        'true'
                    );

                    return;

                }


                button.dataset.loading =
                    'false';

                button.disabled =
                    false;

                button.removeAttribute(
                    'disabled'
                );

                button.classList.remove(
                    'is-loading'
                );

                button.removeAttribute(
                    'aria-busy'
                );

            };


            /*
            |--------------------------------------------------------------------------
            | Quantity Button State
            |--------------------------------------------------------------------------
            */

            const updateQuantityButtons = function (
                item
            ) {

                if (!item) {
                    return;
                }


                if (
                    item.dataset.quantityLoading ===
                    'true'
                ) {
                    return;
                }


                const input =
                    item.querySelector(
                        '.quantity-input'
                    );


                const decreaseButton =
                    item.querySelector(
                        '.quantity-minus'
                    );


                const increaseButton =
                    item.querySelector(
                        '.quantity-plus'
                    );


                if (
                    !input ||
                    !decreaseButton ||
                    !increaseButton
                ) {
                    return;
                }


                const quantity =
                    parseInt(
                        input.value,
                        10
                    ) || 1;


                const maxQuantity =
                    parseInt(
                        input.max,
                        10
                    ) || 999;


                const isUnavailable =
                    item.classList.contains(
                        'is-unavailable'
                    );


                /*
                |--------------------------------------------------------------------------
                | Decrease
                |--------------------------------------------------------------------------
                |
                | Quantity 1 remains enabled.
                | Clicking it removes the item.
                |
                */

                decreaseButton.disabled =
                    isUnavailable;


                if (isUnavailable) {

                    decreaseButton.setAttribute(
                        'disabled',
                        ''
                    );

                } else {

                    decreaseButton.removeAttribute(
                        'disabled'
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | Increase
                |--------------------------------------------------------------------------
                */

                const shouldDisableIncrease =
                    isUnavailable ||
                    quantity >= maxQuantity;


                increaseButton.disabled =
                    shouldDisableIncrease;


                if (shouldDisableIncrease) {

                    increaseButton.setAttribute(
                        'disabled',
                        ''
                    );

                } else {

                    increaseButton.removeAttribute(
                        'disabled'
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | Restore Icons
                |--------------------------------------------------------------------------
                */

                const minusIcon =
                    decreaseButton.querySelector(
                        'i'
                    );


                const plusIcon =
                    increaseButton.querySelector(
                        'i'
                    );


                if (minusIcon) {

                    minusIcon.className =
                        'ri-subtract-line';

                }


                if (plusIcon) {

                    plusIcon.className =
                        'ri-add-line';

                }

            };


            /*
            |--------------------------------------------------------------------------
            | Toast
            |--------------------------------------------------------------------------
            */

            const showMessage = function (
                message,
                type = 'error'
            ) {

                if (
                    window.AppToast &&
                    typeof window.AppToast.fire ===
                    'function'
                ) {

                    window.AppToast.fire({
                        icon: type,
                        title: message
                    });

                    return;

                }


                console[
                    type === 'error'
                        ? 'error'
                        : 'log'
                    ](
                    message
                );

            };


            /*
            |--------------------------------------------------------------------------
            | Header Cart Count
            |--------------------------------------------------------------------------
            */

            const updateHeaderCartCount = function (
                count
            ) {

                const normalizedCount =
                    Math.max(
                        0,
                        Number(count) || 0
                    );


                document
                    .querySelectorAll(
                        '[data-cart-count]'
                    )
                    .forEach(
                        function (element) {

                            element.textContent =
                                normalizedCount;

                        }
                    );

            };


            /*
            |--------------------------------------------------------------------------
            | Empty State
            |--------------------------------------------------------------------------
            */

            const updateEmptyState = function () {

                const items =
                    cartPage.querySelectorAll(
                        '.cart-item'
                    );


                const itemCount =
                    items.length;


                let totalQuantity = 0;


                items.forEach(
                    function (item) {

                        const input =
                            item.querySelector(
                                '.quantity-input'
                            );


                        if (input) {

                            totalQuantity +=
                                parseInt(
                                    input.value,
                                    10
                                ) || 0;

                        }

                    }
                );


                if (cartProductCount) {

                    cartProductCount.textContent =
                        totalQuantity +
                        (
                            totalQuantity === 1
                                ? ' Product'
                                : ' Products'
                        );

                }


                if (itemCount === 0) {

                    if (cartGrid) {

                        cartGrid.style.display =
                            'none';

                    }


                    if (emptyState) {

                        emptyState.classList.add(
                            'is-visible'
                        );

                    }

                } else {

                    if (cartGrid) {

                        cartGrid.style.display =
                            '';

                    }


                    if (emptyState) {

                        emptyState.classList.remove(
                            'is-visible'
                        );

                    }

                }

            };


            /*
            |--------------------------------------------------------------------------
            | Calculate Product Shipping
            |--------------------------------------------------------------------------
            |
            | IMPORTANT:
            |
            | Shipping is per cart line/product.
            | Quantity does not multiply shipping.
            |
            */

            const calculateShipping = function () {

                const items =
                    cartPage.querySelectorAll(
                        '.cart-item'
                    );


                let shipping = 0;


                items.forEach(
                    function (item) {

                        const shippingCost =
                            Number(
                                item.dataset.shippingCost
                            ) || 0;


                        shipping +=
                            Math.max(
                                0,
                                shippingCost
                            );

                    }
                );


                return shipping;

            };


            /*
            |--------------------------------------------------------------------------
            | Update Totals
            |--------------------------------------------------------------------------
            */

            const updateTotals = function () {

                const items =
                    cartPage.querySelectorAll(
                        '.cart-item'
                    );


                let subtotal = 0;

                let totalQuantity = 0;


                items.forEach(
                    function (item) {

                        const price =
                            Number(
                                item.dataset.price
                            ) || 0;


                        const quantityInput =
                            item.querySelector(
                                '.quantity-input'
                            );


                        const itemTotalElement =
                            item.querySelector(
                                '.item-total'
                            );


                        const quantity =
                            parseInt(
                                quantityInput?.value,
                                10
                            ) || 0;


                        const itemTotal =
                            price *
                            quantity;


                        subtotal +=
                            itemTotal;


                        totalQuantity +=
                            quantity;


                        if (itemTotalElement) {

                            itemTotalElement.textContent =
                                formatPrice(
                                    itemTotal
                                );

                        }


                        updateQuantityButtons(
                            item
                        );

                    }
                );


                /*
                |--------------------------------------------------------------------------
                | Shipping
                |--------------------------------------------------------------------------
                */

                const shipping =
                    calculateShipping();


                /*
                |--------------------------------------------------------------------------
                | Discount / Tax
                |--------------------------------------------------------------------------
                |
                | These values are calculated by backend.
                |
                */

                const discount =
                    hasAppliedCoupon
                        ? initialDiscount
                        : 0;


                const tax =
                    hasAppliedCoupon
                        ? initialTax
                        : 0;


                /*
                |--------------------------------------------------------------------------
                | Final Total
                |--------------------------------------------------------------------------
                */

                const total =
                    Math.max(
                        0,
                        subtotal +
                        shipping +
                        tax -
                        discount
                    );


                /*
                |--------------------------------------------------------------------------
                | Update Subtotal
                |--------------------------------------------------------------------------
                */

                if (subtotalElement) {

                    subtotalElement.textContent =
                        formatPrice(
                            subtotal
                        );

                }


                /*
                |--------------------------------------------------------------------------
                | Update Shipping
                |--------------------------------------------------------------------------
                */

                if (shippingElement) {

                    shippingElement.textContent =
                        formatPrice(
                            shipping
                        );

                }


                /*
                |--------------------------------------------------------------------------
                | Update Discount
                |--------------------------------------------------------------------------
                */

                if (discountElement) {

                    discountElement.textContent =
                        '-' +
                        formatPrice(
                            discount
                        );

                }


                /*
                |--------------------------------------------------------------------------
                | Update Tax
                |--------------------------------------------------------------------------
                */

                if (taxElement) {

                    taxElement.textContent =
                        formatPrice(
                            tax
                        );

                }


                /*
                |--------------------------------------------------------------------------
                | Update Total
                |--------------------------------------------------------------------------
                */

                if (totalElement) {

                    totalElement.textContent =
                        formatPrice(
                            total
                        );

                }


                /*
                |--------------------------------------------------------------------------
                | Product Count
                |--------------------------------------------------------------------------
                */

                if (cartProductCount) {

                    cartProductCount.textContent =
                        totalQuantity +
                        (
                            totalQuantity === 1
                                ? ' Product'
                                : ' Products'
                        );

                }


                updateEmptyState();

            };


            /*
            |--------------------------------------------------------------------------
            | API Request
            |--------------------------------------------------------------------------
            */

            const sendRequest = async function (
                url,
                method,
                body = null
            ) {

                if (!csrfToken) {

                    throw new Error(
                        'CSRF token is missing.'
                    );

                }


                const options = {

                    method,

                    credentials:
                        'same-origin',

                    headers: {

                        'Accept':
                            'application/json',

                        'X-CSRF-TOKEN':
                        csrfToken,

                        'X-Requested-With':
                            'XMLHttpRequest'

                    }

                };


                if (body !== null) {

                    options.headers[
                        'Content-Type'
                        ] =
                        'application/json';


                    options.body =
                        JSON.stringify(
                            body
                        );

                }


                const response =
                    await fetch(
                        url,
                        options
                    );


                let data = null;


                try {

                    data =
                        await response.json();

                } catch {

                    data = null;

                }


                if (!response.ok) {

                    const message =
                        data?.message ||
                        data?.errors?.code?.[0] ||
                        data?.errors?.quantity?.[0] ||
                        data?.errors?.product_id?.[0] ||
                        'Unable to update your cart.';


                    throw new Error(
                        message
                    );

                }


                return data;

            };


            /*
            |--------------------------------------------------------------------------
            | Reload Cart
            |--------------------------------------------------------------------------
            */

            const reloadCart = function () {

                window.location.reload();

            };


            /*
            |--------------------------------------------------------------------------
            | Apply Coupon
            |--------------------------------------------------------------------------
            */

            const applyCoupon = async function () {

                if (!promoInput) {
                    return;
                }


                if (!applyPromoButton) {
                    return;
                }


                if (
                    applyPromoButton.dataset.loading ===
                    'true'
                ) {
                    return;
                }


                const code =
                    promoInput.value
                        .trim()
                        .toUpperCase();


                if (!code) {

                    showMessage(
                        'Please enter a promo code.'
                    );

                    promoInput.focus();

                    return;

                }


                setButtonLoading(
                    applyPromoButton,
                    true
                );


                try {

                    await sendRequest(
                        '{{ route('cart.coupon.apply') }}',
                        'POST',
                        {
                            code
                        }
                    );


                    reloadCart();

                } catch (error) {

                    showMessage(
                        error.message ||
                        'Unable to apply promo code.'
                    );


                    setButtonLoading(
                        applyPromoButton,
                        false
                    );

                }

            };


            /*
            |--------------------------------------------------------------------------
            | Apply Coupon Click
            |--------------------------------------------------------------------------
            */

            if (applyPromoButton) {

                applyPromoButton.addEventListener(
                    'click',
                    applyCoupon
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Coupon Enter
            |--------------------------------------------------------------------------
            */

            if (promoInput) {

                promoInput.addEventListener(
                    'keydown',
                    function (event) {

                        if (
                            event.key ===
                            'Enter'
                        ) {

                            event.preventDefault();

                            applyCoupon();

                        }

                    }
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Remove Coupon
            |--------------------------------------------------------------------------
            */

            if (removePromoButton) {

                removePromoButton.addEventListener(
                    'click',
                    async function () {

                        if (
                            removePromoButton.dataset.loading ===
                            'true'
                        ) {
                            return;
                        }


                        setButtonLoading(
                            removePromoButton,
                            true
                        );


                        try {

                            await sendRequest(
                                '{{ route('cart.coupon.remove') }}',
                                'DELETE'
                            );


                            reloadCart();

                        } catch (error) {

                            showMessage(
                                error.message ||
                                'Unable to remove promo code.'
                            );


                            setButtonLoading(
                                removePromoButton,
                                false
                            );

                        }

                    }
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Update Cart Quantity
            |--------------------------------------------------------------------------
            */

            const updateCartQuantity = async function (
                item,
                button,
                newQuantity
            ) {

                if (!item || !button) {
                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | Prevent Parallel Requests
                |--------------------------------------------------------------------------
                */

                if (
                    item.dataset.quantityLoading ===
                    'true'
                ) {
                    return;
                }


                item.dataset.quantityLoading =
                    'true';


                const quantityButtons =
                    item.querySelectorAll(
                        '.quantity-btn'
                    );


                quantityButtons.forEach(
                    function (quantityButton) {

                        quantityButton.disabled =
                            true;

                        quantityButton.setAttribute(
                            'disabled',
                            ''
                        );

                    }
                );


                setQuantityButtonLoading(
                    button,
                    true
                );


                try {

                    const data =
                        await sendRequest(
                            item.dataset.updateUrl,
                            'PATCH',
                            {
                                quantity:
                                newQuantity
                            }
                        );


                    const input =
                        item.querySelector(
                            '.quantity-input'
                        );


                    const serverQuantity =
                        Number(
                            data.quantity ??
                            newQuantity
                        );


                    if (input) {

                        input.value =
                            serverQuantity;

                    }


                    updateHeaderCartCount(
                        data.cart_count ??
                        0
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | Coupon
                    |--------------------------------------------------------------------------
                    |
                    | Backend recalculates coupon.
                    |
                    */

                    if (hasAppliedCoupon) {

                        reloadCart();

                        return;

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Reset Loading
                    |--------------------------------------------------------------------------
                    */

                    item.dataset.quantityLoading =
                        'false';


                    quantityButtons.forEach(
                        function (quantityButton) {

                            setQuantityButtonLoading(
                                quantityButton,
                                false
                            );

                        }
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | Update Quantity State
                    |--------------------------------------------------------------------------
                    */

                    updateQuantityButtons(
                        item
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | Update Totals
                    |--------------------------------------------------------------------------
                    |
                    | Shipping is recalculated from
                    | data-shipping-cost.
                    |
                    */

                    updateTotals();

                } catch (error) {

                    item.dataset.quantityLoading =
                        'false';


                    quantityButtons.forEach(
                        function (quantityButton) {

                            setQuantityButtonLoading(
                                quantityButton,
                                false
                            );

                        }
                    );


                    showMessage(
                        error.message ||
                        'Unable to update quantity.'
                    );


                    updateQuantityButtons(
                        item
                    );

                }

            };


            /*
            |--------------------------------------------------------------------------
            | Cart Item Actions
            |--------------------------------------------------------------------------
            */

            cartPage.addEventListener(
                'click',
                async function (event) {

                    const increaseButton =
                        event.target.closest(
                            '.quantity-plus'
                        );


                    const decreaseButton =
                        event.target.closest(
                            '.quantity-minus'
                        );


                    const removeButton =
                        event.target.closest(
                            '.cart-item-remove'
                        );


                    if (
                        !increaseButton &&
                        !decreaseButton &&
                        !removeButton
                    ) {

                        return;

                    }


                    const item =
                        event.target.closest(
                            '.cart-item'
                        );


                    if (!item) {
                        return;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Prevent Parallel Requests
                    |--------------------------------------------------------------------------
                    */

                    if (
                        item.dataset.quantityLoading ===
                        'true'
                    ) {
                        return;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Remove Item
                    |--------------------------------------------------------------------------
                    */

                    if (removeButton) {

                        if (
                            removeButton.disabled ||
                            removeButton.dataset.loading ===
                            'true'
                        ) {
                            return;
                        }


                        setButtonLoading(
                            removeButton,
                            true
                        );


                        try {

                            const data =
                                await sendRequest(
                                    removeButton.dataset.removeUrl,
                                    'DELETE'
                                );


                            item.remove();


                            updateHeaderCartCount(
                                data.cart_count ??
                                0
                            );


                            if (hasAppliedCoupon) {

                                reloadCart();

                                return;

                            }


                            showMessage(
                                data.message ||
                                'Item removed from cart.',
                                'success'
                            );


                            updateTotals();

                        } catch (error) {

                            showMessage(
                                error.message ||
                                'Unable to remove item.'
                            );


                            setButtonLoading(
                                removeButton,
                                false
                            );

                        }


                        return;

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Quantity Input
                    |--------------------------------------------------------------------------
                    */

                    const input =
                        item.querySelector(
                            '.quantity-input'
                        );


                    if (!input) {
                        return;
                    }


                    const currentQuantity =
                        parseInt(
                            input.value,
                            10
                        ) || 1;


                    const maxQuantity =
                        parseInt(
                            input.max,
                            10
                        ) || 999;


                    /*
                    |--------------------------------------------------------------------------
                    | Increase
                    |--------------------------------------------------------------------------
                    */

                    if (increaseButton) {

                        if (
                            increaseButton.disabled ||
                            currentQuantity >=
                            maxQuantity
                        ) {

                            return;

                        }


                        const newQuantity =
                            currentQuantity + 1;


                        await updateCartQuantity(
                            item,
                            increaseButton,
                            newQuantity
                        );


                        return;

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Decrease
                    |--------------------------------------------------------------------------
                    */

                    if (decreaseButton) {

                        if (
                            decreaseButton.disabled
                        ) {

                            return;

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Quantity 1 -> Remove
                        |--------------------------------------------------------------------------
                        */

                        if (
                            currentQuantity <= 1
                        ) {

                            item.dataset.quantityLoading =
                                'true';


                            setQuantityButtonLoading(
                                decreaseButton,
                                true
                            );


                            try {

                                const data =
                                    await sendRequest(
                                        item.dataset.removeUrl,
                                        'DELETE'
                                    );


                                item.remove();


                                updateHeaderCartCount(
                                    data.cart_count ??
                                    0
                                );


                                if (hasAppliedCoupon) {

                                    reloadCart();

                                    return;

                                }


                                showMessage(
                                    data.message ||
                                    'Item removed from cart.',
                                    'success'
                                );


                                updateTotals();

                            } catch (error) {

                                item.dataset.quantityLoading =
                                    'false';


                                setQuantityButtonLoading(
                                    decreaseButton,
                                    false
                                );


                                showMessage(
                                    error.message ||
                                    'Unable to remove item.'
                                );


                                updateQuantityButtons(
                                    item
                                );

                            }


                            return;

                        }


                        const newQuantity =
                            currentQuantity - 1;


                        await updateCartQuantity(
                            item,
                            decreaseButton,
                            newQuantity
                        );

                    }

                }
            );


            /*
            |--------------------------------------------------------------------------
            | Clear Cart
            |--------------------------------------------------------------------------
            */

            if (clearCartButton) {

                clearCartButton.addEventListener(
                    'click',
                    async function () {

                        const items =
                            cartPage.querySelectorAll(
                                '.cart-item'
                            );


                        if (
                            items.length === 0 ||
                            clearCartButton.dataset.loading ===
                            'true'
                        ) {
                            return;
                        }


                        setButtonLoading(
                            clearCartButton,
                            true
                        );


                        try {

                            const data =
                                await sendRequest(
                                    '{{ route('cart.clear') }}',
                                    'DELETE'
                                );


                            items.forEach(
                                function (item) {

                                    item.remove();

                                }
                            );


                            updateHeaderCartCount(
                                data.cart_count ??
                                0
                            );


                            reloadCart();

                        } catch (error) {

                            showMessage(
                                error.message ||
                                'Unable to clear cart.'
                            );


                            setButtonLoading(
                                clearCartButton,
                                false
                            );

                        }

                    }
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Checkout Validation
            |--------------------------------------------------------------------------
            */

            if (checkoutButton) {

                checkoutButton.addEventListener(
                    'click',
                    function (event) {

                        const items =
                            cartPage.querySelectorAll(
                                '.cart-item'
                            );


                        if (items.length === 0) {

                            event.preventDefault();

                            updateEmptyState();

                            return;

                        }


                        const unavailableItems =
                            cartPage.querySelectorAll(
                                '.cart-item.is-unavailable'
                            );


                        if (
                            unavailableItems.length > 0
                        ) {

                            event.preventDefault();

                            showMessage(
                                'Please remove unavailable items before proceeding to checkout.'
                            );

                        }

                    }
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Initial Quantity State
            |--------------------------------------------------------------------------
            */

            cartPage
                .querySelectorAll(
                    '.cart-item'
                )
                .forEach(
                    function (item) {

                        updateQuantityButtons(
                            item
                        );

                    }
                );


            /*
            |--------------------------------------------------------------------------
            | Initial Totals
            |--------------------------------------------------------------------------
            */

            updateTotals();

        });
    </script>

@endpush
