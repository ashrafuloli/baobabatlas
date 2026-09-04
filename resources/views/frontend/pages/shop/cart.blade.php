@extends('frontend.layouts.frontend')

    @section('contents')

        <section class="shopping-cart-page section-padding">
            <div class="container">

                {{-- Breadcrumb --}}
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


                {{-- Page Header --}}
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


                    <a href="{{ route('shop') }}"
                       class="cart-continue-btn">
                        <i class="ri-arrow-left-line"></i>

                        <span>
                        Continue Shopping
                    </span>
                    </a>

                </div>


                <div class="cart-page-grid">

                    {{-- Cart Items --}}
                    <div class="cart-items-wrapper">

                        <div class="cart-items-card">

                            <div class="cart-items-card__header">

                                <div>
                                <span class="section-subtitle">
                                    CART ITEMS
                                </span>

                                    <h2 class="cart-product-count">
                                        3 Products
                                    </h2>
                                </div>


                                <button type="button"
                                        class="clear-cart-btn">
                                    <i class="ri-delete-bin-line"></i>

                                    <span>
                                    Clear Cart
                                </span>
                                </button>

                            </div>


                            <div class="cart-items-list">


                                {{-- Cart Item 1 --}}
                                <div class="cart-item"
                                     data-price="29.99">

                                    <div class="cart-item__image">
                                        <img src="{{ asset('assets/img/products/thumb-1.jpeg') }}"
                                             alt="Premium Cotton T-Shirt">
                                    </div>


                                    <div class="cart-item__content">

                                    <span class="cart-item__category">
                                        T-shirts
                                    </span>

                                        <h3>
                                            <a href="#">
                                                Premium Cotton T-Shirt
                                            </a>
                                        </h3>

                                        <div class="cart-item__meta">
                                        <span>
                                            <strong>Size:</strong> M
                                        </span>

                                            <span>
                                            <strong>Color:</strong> Black
                                        </span>

                                            <span>
                                            <strong>SKU:</strong> TSH-BLK-M
                                        </span>
                                        </div>


                                        <div class="cart-item__bottom">

                                            <div class="quantity-control">

                                                <button type="button"
                                                        class="quantity-btn quantity-minus"
                                                        aria-label="Decrease quantity">
                                                    <i class="ri-subtract-line"></i>
                                                </button>

                                                <input type="number"
                                                       class="quantity-input"
                                                       value="1"
                                                       min="1"
                                                       readonly>

                                                <button type="button"
                                                        class="quantity-btn quantity-plus"
                                                        aria-label="Increase quantity">
                                                    <i class="ri-add-line"></i>
                                                </button>

                                            </div>


                                            <div class="cart-item__price">

                                            <span class="unit-price">
                                                $29.99 each
                                            </span>

                                                <strong class="item-total">
                                                    $29.99
                                                </strong>

                                            </div>

                                        </div>

                                    </div>


                                    <button type="button"
                                            class="cart-item-remove"
                                            aria-label="Remove item">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>

                                </div>


                                {{-- Cart Item 2 --}}
                                <div class="cart-item"
                                     data-price="54.99">

                                    <div class="cart-item__image">
                                        <img src="{{ asset('assets/img/products/thumb-2.jpeg') }}"
                                             alt="Everyday Backpack">
                                    </div>


                                    <div class="cart-item__content">

                                    <span class="cart-item__category">
                                        Bags
                                    </span>

                                        <h3>
                                            <a href="#">
                                                Everyday Backpack
                                            </a>
                                        </h3>

                                        <div class="cart-item__meta">
                                        <span>
                                            <strong>Color:</strong> Black
                                        </span>

                                            <span>
                                            <strong>Material:</strong> Canvas
                                        </span>

                                            <span>
                                            <strong>SKU:</strong> BAG-BLK-01
                                        </span>
                                        </div>


                                        <div class="cart-item__bottom">

                                            <div class="quantity-control">

                                                <button type="button"
                                                        class="quantity-btn quantity-minus">
                                                    <i class="ri-subtract-line"></i>
                                                </button>

                                                <input type="number"
                                                       class="quantity-input"
                                                       value="1"
                                                       min="1"
                                                       readonly>

                                                <button type="button"
                                                        class="quantity-btn quantity-plus">
                                                    <i class="ri-add-line"></i>
                                                </button>

                                            </div>


                                            <div class="cart-item__price">

                                            <span class="unit-price">
                                                $54.99 each
                                            </span>

                                                <strong class="item-total">
                                                    $54.99
                                                </strong>

                                            </div>

                                        </div>

                                    </div>


                                    <button type="button"
                                            class="cart-item-remove"
                                            aria-label="Remove item">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>

                                </div>


                                {{-- Cart Item 3 --}}
                                <div class="cart-item"
                                     data-price="19.99">

                                    <div class="cart-item__image">
                                        <img src="{{ asset('assets/img/products/thumb-3.jpeg') }}"
                                             alt="Classic Ceramic Mug">
                                    </div>


                                    <div class="cart-item__content">

                                    <span class="cart-item__category">
                                        Accessories
                                    </span>

                                        <h3>
                                            <a href="#">
                                                Classic Ceramic Mug
                                            </a>
                                        </h3>

                                        <div class="cart-item__meta">
                                        <span>
                                            <strong>Color:</strong> White
                                        </span>

                                            <span>
                                            <strong>Capacity:</strong> 350ml
                                        </span>

                                            <span>
                                            <strong>SKU:</strong> MUG-WHT-01
                                        </span>
                                        </div>


                                        <div class="cart-item__bottom">

                                            <div class="quantity-control">

                                                <button type="button"
                                                        class="quantity-btn quantity-minus">
                                                    <i class="ri-subtract-line"></i>
                                                </button>

                                                <input type="number"
                                                       class="quantity-input"
                                                       value="1"
                                                       min="1"
                                                       readonly>

                                                <button type="button"
                                                        class="quantity-btn quantity-plus">
                                                    <i class="ri-add-line"></i>
                                                </button>

                                            </div>


                                            <div class="cart-item__price">

                                            <span class="unit-price">
                                                $19.99 each
                                            </span>

                                                <strong class="item-total">
                                                    $19.99
                                                </strong>

                                            </div>

                                        </div>

                                    </div>


                                    <button type="button"
                                            class="cart-item-remove"
                                            aria-label="Remove item">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>

                                </div>

                            </div>


                            <div class="cart-items-card__footer">

                                <a href="{{ route('shop') }}"
                                   class="cart-footer-continue">
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


                    {{-- Cart Sidebar --}}
                    <aside class="cart-sidebar">


                        {{-- Order Summary --}}
                        <div class="cart-summary-card">

                            <div class="cart-summary-card__header">

                            <span class="section-subtitle">
                                ORDER SUMMARY
                            </span>

                                <h2>
                                    Cart Total
                                </h2>

                            </div>


                            <div class="promo-code">

                                <label for="promo-code">
                                    Have a promo code?
                                </label>

                                <div class="promo-code__field">

                                    <input type="text"
                                           id="promo-code"
                                           placeholder="Enter code">

                                    <button type="button"
                                            class="apply-promo-btn">
                                        Apply
                                    </button>

                                </div>

                            </div>


                            <div class="cart-summary-list">

                                <div class="summary-row">
                                <span>
                                    Subtotal
                                </span>

                                    <strong class="summary-subtotal">
                                        $104.97
                                    </strong>
                                </div>


                                <div class="summary-row">
                                <span>
                                    Shipping
                                </span>

                                    <strong>
                                        $0.00
                                    </strong>
                                </div>


                                <div class="summary-row summary-discount">
                                <span>
                                    Discount
                                </span>

                                    <strong class="summary-discount-value">
                                        -$0.00
                                    </strong>
                                </div>


                                <div class="summary-row">
                                <span>
                                    Tax
                                </span>

                                    <strong>
                                        $0.00
                                    </strong>
                                </div>

                            </div>


                            <div class="cart-summary-total">

                            <span>
                                Total
                            </span>

                                <strong class="summary-total">
                                    $104.97
                                </strong>

                            </div>


                            <a href="checkout"
                               class="checkout-btn">
                            <span>
                                Proceed to Checkout
                            </span>

                                <i class="ri-arrow-right-line"></i>
                            </a>


                            <div class="checkout-security">
                                <i class="ri-shield-check-line"></i>

                                <span>
                                Secure checkout & protected payment
                            </span>
                            </div>

                        </div>


                        {{-- Cart Benefits --}}
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


                {{-- Empty Cart --}}
                <div class="cart-empty-state">
                    <div class="cart-empty-state__icon">
                        <i class="ri-shopping-bag-line"></i>
                    </div>

                    <h2>
                        Your cart is empty
                    </h2>

                    <p>
                        Looks like you haven't added anything to your cart yet.
                    </p>

                    <a href="{{ route('shop') }}"
                       class="cart-continue-btn">
                        Continue Shopping
                        <i class="ri-arrow-right-line"></i>
                    </a>
                </div>

            </div>
        </section>

        <script>
            document.addEventListener('DOMContentLoaded', function () {

                const cartPage =
                    document.querySelector('.shopping-cart-page');


                if (!cartPage) {
                    return;
                }


                const cartItemsList =
                    cartPage.querySelector('.cart-items-list');

                const cartProductCount =
                    cartPage.querySelector('.cart-product-count');

                const subtotalElement =
                    cartPage.querySelector('.summary-subtotal');

                const totalElement =
                    cartPage.querySelector('.summary-total');

                const discountElement =
                    cartPage.querySelector('.summary-discount-value');

                const clearCartButton =
                    cartPage.querySelector('.clear-cart-btn');

                const emptyState =
                    cartPage.querySelector('.cart-empty-state');

                const cartGrid =
                    cartPage.querySelector('.cart-page-grid');

                const discountRate = 0;


                const formatPrice = function (price) {

                    return '$' +
                        Number(price).toFixed(2);

                };


                const updateCart = function () {

                    const cartItems =
                        cartPage.querySelectorAll('.cart-item');


                    let subtotal = 0;


                    cartItems.forEach(function (item) {

                        const price =
                            parseFloat(
                                item.dataset.price
                            );

                        const quantityInput =
                            item.querySelector(
                                '.quantity-input'
                            );

                        const itemTotal =
                            price *
                            parseInt(
                                quantityInput.value,
                                10
                            );


                        const itemTotalElement =
                            item.querySelector(
                                '.item-total'
                            );


                        itemTotalElement.textContent =
                            formatPrice(itemTotal);


                        subtotal += itemTotal;

                    });


                    const discount =
                        subtotal *
                        discountRate;


                    const total =
                        subtotal -
                        discount;


                    subtotalElement.textContent =
                        formatPrice(subtotal);

                    discountElement.textContent =
                        '-' +
                        formatPrice(discount);

                    totalElement.textContent =
                        formatPrice(total);


                    const itemCount =
                        cartItems.length;


                    cartProductCount.textContent =
                        itemCount +
                        (itemCount === 1
                            ? ' Product'
                            : ' Products');


                    if (itemCount === 0) {

                        cartGrid.style.display =
                            'none';

                        emptyState.classList.add(
                            'is-visible'
                        );

                    } else {

                        cartGrid.style.display =
                            '';

                        emptyState.classList.remove(
                            'is-visible'
                        );

                    }

                };


                cartPage.addEventListener(
                    'click',
                    function (event) {

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


                        if (increaseButton) {

                            const item =
                                increaseButton.closest(
                                    '.cart-item'
                                );

                            const input =
                                item.querySelector(
                                    '.quantity-input'
                                );


                            input.value =
                                parseInt(
                                    input.value,
                                    10
                                ) + 1;


                            updateCart();

                        }


                        if (decreaseButton) {

                            const item =
                                decreaseButton.closest(
                                    '.cart-item'
                                );

                            const input =
                                item.querySelector(
                                    '.quantity-input'
                                );

                            const quantity =
                                parseInt(
                                    input.value,
                                    10
                                );


                            if (quantity > 1) {

                                input.value =
                                    quantity - 1;

                                updateCart();

                            }

                        }


                        if (removeButton) {

                            const item =
                                removeButton.closest(
                                    '.cart-item'
                                );


                            item.remove();

                            updateCart();

                        }

                    }
                );


                if (clearCartButton) {

                    clearCartButton.addEventListener(
                        'click',
                        function () {

                            const cartItems =
                                cartPage.querySelectorAll(
                                    '.cart-item'
                                );


                            cartItems.forEach(
                                function (item) {

                                    item.remove();

                                }
                            );


                            updateCart();

                        }
                    );

                }


                updateCart();

            });
        </script>

    @endsection
