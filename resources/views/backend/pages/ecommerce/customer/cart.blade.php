@extends('backend.layouts.backend')

@section('title', 'Shopping Cart')

@section('content')

    <div class="customer-cart-page">

        {{-- ================================================================ --}}
        {{-- BREADCRUMB --}}
        {{-- ================================================================ --}}

        <div class="customer-cart-breadcrumb">

            <a href="{{ route('customer-shop') }}">
                Shop
            </a>

            <i class="ri-arrow-right-s-line"></i>

            <span>
            Cart
        </span>

        </div>


        {{-- ================================================================ --}}
        {{-- HEADER --}}
        {{-- ================================================================ --}}

        <div class="customer-cart-header">

            <div>

            <span class="customer-cart-header__eyebrow">
                Shopping Cart
            </span>

                <h1>
                    Your Cart
                </h1>

                <p>
                    Review your items before proceeding to checkout.
                </p>

            </div>


            <a
                href="{{ route('customer-shop') }}"
                class="customer-cart-header__continue"
            >
                <i class="ri-arrow-left-line"></i>
                Continue Shopping
            </a>

        </div>


        {{-- ================================================================ --}}
        {{-- CART CONTENT --}}
        {{-- ================================================================ --}}

        <div class="customer-cart-layout">


            {{-- ============================================================ --}}
            {{-- CART ITEMS --}}
            {{-- ============================================================ --}}

            <main class="customer-cart-main">

                <section class="customer-cart-items-card">


                    {{-- CARD HEADER --}}

                    <div class="customer-cart-items-card__header">

                        <div>

                        <span>
                            Cart Items
                        </span>

                            <h2>
                                3 Products
                            </h2>

                        </div>


                        <button
                            type="button"
                            class="customer-cart-clear"
                            id="clear-cart"
                        >
                            <i class="ri-delete-bin-line"></i>
                            Clear Cart
                        </button>

                    </div>


                    {{-- ==================================================== --}}
                    {{-- PRODUCT 1 --}}
                    {{-- ==================================================== --}}

                    <div
                        class="customer-cart-item"
                        data-cart-item
                        data-price="29.99"
                    >

                        <div class="customer-cart-item__image">

                            <img
                                src="https://placehold.co/120x140"
                                alt="Premium Cotton T-Shirt"
                            >

                        </div>


                        <div class="customer-cart-item__details">

                            <div class="customer-cart-item__top">

                                <div>

                                <span class="customer-cart-item__category">
                                    T-Shirts
                                </span>

                                    <h3>
                                        Premium Cotton T-Shirt
                                    </h3>

                                </div>


                                <button
                                    type="button"
                                    class="customer-cart-item__remove"
                                    data-remove-item
                                    aria-label="Remove Premium Cotton T-Shirt"
                                >
                                    <i class="ri-delete-bin-line"></i>
                                </button>

                            </div>


                            <div class="customer-cart-item__meta">

                            <span>
                                <strong>
                                    Size:
                                </strong>
                                M
                            </span>

                                <span>
                                <strong>
                                    Color:
                                </strong>
                                Black
                            </span>

                                <span>
                                <strong>
                                    SKU:
                                </strong>
                                TSH-BLK-M
                            </span>

                            </div>


                            <div class="customer-cart-item__bottom">

                                <div class="customer-cart-quantity">

                                    <button
                                        type="button"
                                        data-quantity-minus
                                        aria-label="Decrease quantity"
                                    >
                                        <i class="ri-subtract-line"></i>
                                    </button>

                                    <input
                                        type="text"
                                        value="1"
                                        data-quantity
                                        readonly
                                    >

                                    <button
                                        type="button"
                                        data-quantity-plus
                                        aria-label="Increase quantity"
                                    >
                                        <i class="ri-add-line"></i>
                                    </button>

                                </div>


                                <div class="customer-cart-item__price">

                                <span>
                                    $29.99 each
                                </span>

                                    <strong data-item-total>
                                        $29.99
                                    </strong>

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- ==================================================== --}}
                    {{-- PRODUCT 2 --}}
                    {{-- ==================================================== --}}

                    <div
                        class="customer-cart-item"
                        data-cart-item
                        data-price="54.99"
                    >

                        <div class="customer-cart-item__image">

                            <img
                                src="https://placehold.co/120x140"
                                alt="Everyday Backpack"
                            >

                        </div>


                        <div class="customer-cart-item__details">

                            <div class="customer-cart-item__top">

                                <div>

                                <span class="customer-cart-item__category">
                                    Bags
                                </span>

                                    <h3>
                                        Everyday Backpack
                                    </h3>

                                </div>


                                <button
                                    type="button"
                                    class="customer-cart-item__remove"
                                    data-remove-item
                                    aria-label="Remove Everyday Backpack"
                                >
                                    <i class="ri-delete-bin-line"></i>
                                </button>

                            </div>


                            <div class="customer-cart-item__meta">

                            <span>
                                <strong>
                                    Color:
                                </strong>
                                Black
                            </span>

                                <span>
                                <strong>
                                    Material:
                                </strong>
                                Canvas
                            </span>

                                <span>
                                <strong>
                                    SKU:
                                </strong>
                                BAG-BLK-01
                            </span>

                            </div>


                            <div class="customer-cart-item__bottom">

                                <div class="customer-cart-quantity">

                                    <button
                                        type="button"
                                        data-quantity-minus
                                        aria-label="Decrease quantity"
                                    >
                                        <i class="ri-subtract-line"></i>
                                    </button>

                                    <input
                                        type="text"
                                        value="1"
                                        data-quantity
                                        readonly
                                    >

                                    <button
                                        type="button"
                                        data-quantity-plus
                                        aria-label="Increase quantity"
                                    >
                                        <i class="ri-add-line"></i>
                                    </button>

                                </div>


                                <div class="customer-cart-item__price">

                                <span>
                                    $54.99 each
                                </span>

                                    <strong data-item-total>
                                        $54.99
                                    </strong>

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- ==================================================== --}}
                    {{-- PRODUCT 3 --}}
                    {{-- ==================================================== --}}

                    <div
                        class="customer-cart-item"
                        data-cart-item
                        data-price="19.99"
                    >

                        <div class="customer-cart-item__image">

                            <img
                                src="https://placehold.co/120x140"
                                alt="Classic Ceramic Mug"
                            >

                        </div>


                        <div class="customer-cart-item__details">

                            <div class="customer-cart-item__top">

                                <div>

                                <span class="customer-cart-item__category">
                                    Accessories
                                </span>

                                    <h3>
                                        Classic Ceramic Mug
                                    </h3>

                                </div>


                                <button
                                    type="button"
                                    class="customer-cart-item__remove"
                                    data-remove-item
                                    aria-label="Remove Classic Ceramic Mug"
                                >
                                    <i class="ri-delete-bin-line"></i>
                                </button>

                            </div>


                            <div class="customer-cart-item__meta">

                            <span>
                                <strong>
                                    Color:
                                </strong>
                                White
                            </span>

                                <span>
                                <strong>
                                    Capacity:
                                </strong>
                                350ml
                            </span>

                                <span>
                                <strong>
                                    SKU:
                                </strong>
                                MUG-WHT-01
                            </span>

                            </div>


                            <div class="customer-cart-item__bottom">

                                <div class="customer-cart-quantity">

                                    <button
                                        type="button"
                                        data-quantity-minus
                                        aria-label="Decrease quantity"
                                    >
                                        <i class="ri-subtract-line"></i>
                                    </button>

                                    <input
                                        type="text"
                                        value="1"
                                        data-quantity
                                        readonly
                                    >

                                    <button
                                        type="button"
                                        data-quantity-plus
                                        aria-label="Increase quantity"
                                    >
                                        <i class="ri-add-line"></i>
                                    </button>

                                </div>


                                <div class="customer-cart-item__price">

                                <span>
                                    $19.99 each
                                </span>

                                    <strong data-item-total>
                                        $19.99
                                    </strong>

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- ==================================================== --}}
                    {{-- EMPTY STATE --}}
                    {{-- ==================================================== --}}

                    <div
                        class="customer-cart-empty"
                        id="cart-empty"
                        hidden
                    >

                        <div class="customer-cart-empty__icon">
                            <i class="ri-shopping-cart-line"></i>
                        </div>

                        <h2>
                            Your cart is empty
                        </h2>

                        <p>
                            Looks like you haven't added anything to your cart yet.
                        </p>

                        <a
                            href="{{ route('customer-shop') }}"
                            class="customer-cart-btn primary"
                        >
                            <i class="ri-shopping-bag-line"></i>
                            Start Shopping
                        </a>

                    </div>


                    {{-- ==================================================== --}}
                    {{-- CART FOOTER --}}
                    {{-- ==================================================== --}}

                    <div class="customer-cart-items-card__footer">

                        <a
                            href="{{ route('customer-shop') }}"
                            class="customer-cart-back"
                        >
                            <i class="ri-arrow-left-line"></i>
                            Continue Shopping
                        </a>

                        <span>
                        Secure checkout available
                        <i class="ri-lock-2-line"></i>
                    </span>

                    </div>

                </section>

            </main>


            {{-- ============================================================ --}}
            {{-- SUMMARY --}}
            {{-- ============================================================ --}}

            <aside class="customer-cart-sidebar">

                <section class="customer-cart-summary">

                    <div class="customer-cart-summary__header">

                        <div>

                        <span>
                            Order Summary
                        </span>

                            <h2>
                                Cart Total
                            </h2>

                        </div>

                    </div>


                    {{-- ==================================================== --}}
                    {{-- COUPON --}}
                    {{-- ==================================================== --}}

                    <div class="customer-cart-coupon">

                        <label for="coupon">
                            Have a promo code?
                        </label>

                        <div>

                            <input
                                type="text"
                                id="coupon"
                                placeholder="Enter code"
                            >

                            <button
                                type="button"
                                id="apply-coupon"
                            >
                                Apply
                            </button>

                        </div>

                        <small
                            id="coupon-message"
                            hidden
                        ></small>

                    </div>


                    {{-- ==================================================== --}}
                    {{-- TOTALS --}}
                    {{-- ==================================================== --}}

                    <div class="customer-cart-summary__totals">

                        <div>

                        <span>
                            Subtotal
                        </span>

                            <strong id="cart-subtotal">
                                $104.97
                            </strong>

                        </div>


                        <div>

                        <span>
                            Shipping
                        </span>

                            <strong id="cart-shipping">
                                $0.00
                            </strong>

                        </div>


                        <div>

                        <span>
                            Discount
                        </span>

                            <strong
                                class="discount"
                                id="cart-discount"
                            >
                                -$0.00
                            </strong>

                        </div>


                        <div>

                        <span>
                            Tax
                        </span>

                            <strong id="cart-tax">
                                $0.00
                            </strong>

                        </div>

                    </div>


                    <div class="customer-cart-summary__total">

                    <span>
                        Total
                    </span>

                        <strong id="cart-total">
                            $104.97
                        </strong>

                    </div>


                    {{-- ==================================================== --}}
                    {{-- CHECKOUT --}}
                    {{-- ==================================================== --}}

                    <a
                        href="{{ route('checkout') }}"
                        class="customer-cart-checkout"
                        id="checkout-button"
                    >
                    <span>
                        Proceed to Checkout
                    </span>

                        <i class="ri-arrow-right-line"></i>
                    </a>


                    <div class="customer-cart-secure">

                        <i class="ri-shield-check-line"></i>

                        <span>
                        Secure checkout & protected payment
                    </span>

                    </div>

                </section>


                {{-- ======================================================== --}}
                {{-- SHIPPING INFO --}}
                {{-- ======================================================== --}}

                <section class="customer-cart-info-card">

                    <div class="customer-cart-info-card__item">

                        <div class="customer-cart-info-card__icon">
                            <i class="ri-truck-line"></i>
                        </div>

                        <div>

                            <strong>
                                Free Shipping
                            </strong>

                            <span>
                            On orders over $50
                        </span>

                        </div>

                    </div>


                    <div class="customer-cart-info-card__item">

                        <div class="customer-cart-info-card__icon">
                            <i class="ri-refresh-line"></i>
                        </div>

                        <div>

                            <strong>
                                Easy Returns
                            </strong>

                            <span>
                            30-day return policy
                        </span>

                        </div>

                    </div>


                    <div class="customer-cart-info-card__item">

                        <div class="customer-cart-info-card__icon">
                            <i class="ri-shield-check-line"></i>
                        </div>

                        <div>

                            <strong>
                                Secure Shopping
                            </strong>

                            <span>
                            Your data is protected
                        </span>

                        </div>

                    </div>

                </section>

            </aside>

        </div>


        {{-- ================================================================ --}}
        {{-- MOBILE SUMMARY --}}
        {{-- ================================================================ --}}

        <div class="customer-cart-mobile-bar">

            <div>

            <span>
                Total
            </span>

                <strong id="mobile-cart-total">
                    $104.97
                </strong>

            </div>


            <a href="{{ route('checkout') }}">
                Checkout
                <i class="ri-arrow-right-line"></i>
            </a>

        </div>

    </div>


    @push('scripts')

        <script>

            document.addEventListener('DOMContentLoaded', function () {

                const cartItems =
                    document.querySelectorAll(
                        '[data-cart-item]'
                    );

                const subtotalElement =
                    document.querySelector(
                        '#cart-subtotal'
                    );

                const totalElement =
                    document.querySelector(
                        '#cart-total'
                    );

                const mobileTotalElement =
                    document.querySelector(
                        '#mobile-cart-total'
                    );

                const emptyCart =
                    document.querySelector(
                        '#cart-empty'
                    );

                const checkoutButton =
                    document.querySelector(
                        '#checkout-button'
                    );


                function money(value) {

                    return '$' + value.toFixed(2);

                }


                function updateCart() {

                    let subtotal = 0;

                    let visibleItems = 0;


                    cartItems.forEach(function (item) {

                        if (item.hidden) {
                            return;
                        }


                        visibleItems++;


                        const price =
                            parseFloat(
                                item.dataset.price
                            ) || 0;


                        const quantityInput =
                            item.querySelector(
                                '[data-quantity]'
                            );


                        const itemTotalElement =
                            item.querySelector(
                                '[data-item-total]'
                            );


                        const quantity =
                            parseInt(
                                quantityInput.value
                            ) || 1;


                        const itemTotal =
                            price * quantity;


                        subtotal += itemTotal;


                        if (itemTotalElement) {

                            itemTotalElement.textContent =
                                money(itemTotal);

                        }

                    });


                    const shipping =
                        subtotal >= 50 || subtotal === 0
                            ? 0
                            : 8.99;


                    const discount = 0;

                    const tax = 0;

                    const total =
                        subtotal
                        + shipping
                        - discount
                        + tax;


                    if (subtotalElement) {

                        subtotalElement.textContent =
                            money(subtotal);

                    }


                    const shippingElement =
                        document.querySelector(
                            '#cart-shipping'
                        );


                    if (shippingElement) {

                        shippingElement.textContent =
                            money(shipping);

                    }


                    const discountElement =
                        document.querySelector(
                            '#cart-discount'
                        );


                    if (discountElement) {

                        discountElement.textContent =
                            '-' + money(discount);

                    }


                    const taxElement =
                        document.querySelector(
                            '#cart-tax'
                        );


                    if (taxElement) {

                        taxElement.textContent =
                            money(tax);

                    }


                    if (totalElement) {

                        totalElement.textContent =
                            money(total);

                    }


                    if (mobileTotalElement) {

                        mobileTotalElement.textContent =
                            money(total);

                    }


                    if (visibleItems === 0) {

                        emptyCart.hidden = false;

                        checkoutButton.classList.add(
                            'disabled'
                        );

                    } else {

                        emptyCart.hidden = true;

                        checkoutButton.classList.remove(
                            'disabled'
                        );

                    }

                }


                /*
                |--------------------------------------------------------------------------
                | QUANTITY
                |--------------------------------------------------------------------------
                */

                cartItems.forEach(function (item) {

                    const minus =
                        item.querySelector(
                            '[data-quantity-minus]'
                        );

                    const plus =
                        item.querySelector(
                            '[data-quantity-plus]'
                        );

                    const input =
                        item.querySelector(
                            '[data-quantity]'
                        );


                    if (minus) {

                        minus.addEventListener(
                            'click',
                            function () {

                                let quantity =
                                    parseInt(input.value) || 1;


                                if (quantity > 1) {

                                    quantity--;

                                    input.value =
                                        quantity;

                                    updateCart();

                                }

                            }
                        );

                    }


                    if (plus) {

                        plus.addEventListener(
                            'click',
                            function () {

                                let quantity =
                                    parseInt(input.value) || 1;


                                if (quantity < 99) {

                                    quantity++;

                                    input.value =
                                        quantity;

                                    updateCart();

                                }

                            }
                        );

                    }

                });


                /*
                |--------------------------------------------------------------------------
                | REMOVE ITEM
                |--------------------------------------------------------------------------
                */

                document.querySelectorAll(
                    '[data-remove-item]'
                ).forEach(function (button) {

                    button.addEventListener(
                        'click',
                        function () {

                            const item =
                                button.closest(
                                    '[data-cart-item]'
                                );


                            if (!item) {
                                return;
                            }


                            item.classList.add(
                                'removing'
                            );


                            setTimeout(function () {

                                item.hidden = true;

                                updateCart();

                            }, 220);

                        }
                    );

                });


                /*
                |--------------------------------------------------------------------------
                | CLEAR CART
                |--------------------------------------------------------------------------
                */

                const clearCart =
                    document.querySelector(
                        '#clear-cart'
                    );


                if (clearCart) {

                    clearCart.addEventListener(
                        'click',
                        function () {

                            cartItems.forEach(
                                function (item) {

                                    item.hidden = true;

                                }
                            );


                            updateCart();

                        }
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | COUPON
                |--------------------------------------------------------------------------
                */

                const applyCoupon =
                    document.querySelector(
                        '#apply-coupon'
                    );


                if (applyCoupon) {

                    applyCoupon.addEventListener(
                        'click',
                        function () {

                            const input =
                                document.querySelector(
                                    '#coupon'
                                );

                            const message =
                                document.querySelector(
                                    '#coupon-message'
                                );


                            if (!input || !message) {
                                return;
                            }


                            const code =
                                input.value
                                    .trim()
                                    .toUpperCase();


                            if (!code) {

                                message.hidden = false;

                                message.textContent =
                                    'Please enter a promo code.';

                                message.className =
                                    'error';

                                return;

                            }


                            if (code === 'SAVE10') {

                                message.hidden = false;

                                message.textContent =
                                    'Promo code applied successfully.';

                                message.className =
                                    'success';

                            } else {

                                message.hidden = false;

                                message.textContent =
                                    'This promo code is not valid.';

                                message.className =
                                    'error';

                            }

                        }
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | INITIAL CALCULATION
                |--------------------------------------------------------------------------
                */

                updateCart();

            });

        </script>

    @endpush

@endsection
