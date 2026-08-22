@extends('backend.layouts.backend')

@section('title', 'Product Details')

@section('content')

    <div class="customer-product-details">

        {{-- ================================================================ --}}
        {{-- BREADCRUMB --}}
        {{-- ================================================================ --}}

        <div class="customer-product-breadcrumb">

            <a href="{{ route('customer-shop') }}">
                Shop
            </a>

            <i class="ri-arrow-right-s-line"></i>

            <span>
            Clothing
        </span>

            <i class="ri-arrow-right-s-line"></i>

            <span>
            Premium Cotton T-Shirt
        </span>

        </div>


        {{-- ================================================================ --}}
        {{-- PRODUCT MAIN --}}
        {{-- ================================================================ --}}

        <div class="customer-product-main">


            {{-- ============================================================ --}}
            {{-- PRODUCT MEDIA --}}
            {{-- ============================================================ --}}

            <div class="customer-product-media">


                {{-- THUMBNAILS --}}

                <div class="customer-product-thumbnails">


                    <button
                        type="button"
                        class="customer-product-thumbnail active"
                        data-product-image="https://placehold.co/700x820"
                        aria-label="View main product image"
                    >

                        <img
                            src="https://placehold.co/120x140"
                            alt="Premium Cotton T-Shirt"
                        >

                    </button>


                    <button
                        type="button"
                        class="customer-product-thumbnail"
                        data-product-image="https://placehold.co/700x820?text=Side+View"
                        aria-label="View product side image"
                    >

                        <img
                            src="https://placehold.co/120x140?text=Side"
                            alt="Premium Cotton T-Shirt side view"
                        >

                    </button>


                    <button
                        type="button"
                        class="customer-product-thumbnail"
                        data-product-image="https://placehold.co/700x820?text=Back+View"
                        aria-label="View product back image"
                    >

                        <img
                            src="https://placehold.co/120x140?text=Back"
                            alt="Premium Cotton T-Shirt back view"
                        >

                    </button>


                    <button
                        type="button"
                        class="customer-product-thumbnail"
                        data-product-image="https://placehold.co/700x820?text=Detail"
                        aria-label="View product detail image"
                    >

                        <img
                            src="https://placehold.co/120x140?text=Detail"
                            alt="Premium Cotton T-Shirt detail"
                        >

                    </button>


                </div>


                {{-- MAIN IMAGE --}}

                <div class="customer-product-main-image">

                    <img
                        src="https://placehold.co/700x820"
                        alt="Premium Cotton T-Shirt"
                        id="customerProductMainImage"
                    >


                    <span class="customer-product-main-image__badge">
                    Sale
                </span>


                    <button
                        type="button"
                        class="customer-product-main-image__zoom"
                        aria-label="Zoom product image"
                        data-product-zoom
                    >

                        <i class="ri-zoom-in-line"></i>

                    </button>

                </div>


            </div>


            {{-- ============================================================ --}}
            {{-- PRODUCT INFORMATION --}}
            {{-- ============================================================ --}}

            <div class="customer-product-info">


                {{-- CATEGORY --}}

                <span class="customer-product-info__category">
                Clothing
            </span>


                {{-- TITLE --}}

                <h1>
                    Premium Cotton T-Shirt
                </h1>


                {{-- RATING --}}

                <div class="customer-product-info__rating">

                    <div class="customer-product-stars">

                    <span>
                        ★★★★★
                    </span>

                    </div>


                    <a
                        href="#product-reviews"
                        data-open-product-tab="reviews"
                    >
                        24 Reviews
                    </a>


                    <span class="customer-product-info__separator">
                    |
                </span>


                    <span>
                    SKU: TS-001
                </span>

                </div>


                {{-- PRICE --}}

                <div class="customer-product-info__price">

                    <del>
                        $39.99
                    </del>

                    <strong>
                        $29.99
                    </strong>

                    <span>
                    25% OFF
                </span>

                </div>


                {{-- DESCRIPTION --}}

                <div class="customer-product-info__description">

                    <p>
                        Premium quality cotton t-shirt designed for everyday comfort.
                        Soft, breathable and made with durable fabric for long-lasting use.
                    </p>

                </div>


                {{-- STOCK --}}

                <div class="customer-product-stock">

                    <i class="ri-checkbox-circle-fill"></i>

                    <strong>
                        In Stock
                    </strong>

                    <span>
                    18 items available
                </span>

                </div>


                {{-- ======================================================== --}}
                {{-- VARIATIONS --}}
                {{-- ======================================================== --}}

                <div class="customer-product-options">


                    {{-- SIZE --}}

                    <div class="customer-product-option">

                        <div class="customer-product-option__label">

                            <strong>
                                Size
                            </strong>

                            <span>
                            Select Size
                        </span>

                        </div>


                        <div class="customer-product-option__values">


                            <label>

                                <input
                                    type="radio"
                                    name="size"
                                    value="s"
                                >

                                <span>
                                S
                            </span>

                            </label>


                            <label>

                                <input
                                    type="radio"
                                    name="size"
                                    value="m"
                                    checked
                                >

                                <span>
                                M
                            </span>

                            </label>


                            <label>

                                <input
                                    type="radio"
                                    name="size"
                                    value="l"
                                >

                                <span>
                                L
                            </span>

                            </label>


                            <label>

                                <input
                                    type="radio"
                                    name="size"
                                    value="xl"
                                >

                                <span>
                                XL
                            </span>

                            </label>


                        </div>

                    </div>


                    {{-- COLOR --}}

                    <div class="customer-product-option">

                        <div class="customer-product-option__label">

                            <strong>
                                Color
                            </strong>

                            <span>
                            Select Color
                        </span>

                        </div>


                        <div class="customer-product-color-values">


                            <label>

                                <input
                                    type="radio"
                                    name="color"
                                    value="black"
                                    checked
                                >

                                <span class="color-black"></span>

                            </label>


                            <label>

                                <input
                                    type="radio"
                                    name="color"
                                    value="white"
                                >

                                <span class="color-white"></span>

                            </label>


                            <label>

                                <input
                                    type="radio"
                                    name="color"
                                    value="blue"
                                >

                                <span class="color-blue"></span>

                            </label>


                            <label>

                                <input
                                    type="radio"
                                    name="color"
                                    value="gray"
                                >

                                <span class="color-gray"></span>

                            </label>


                        </div>

                    </div>


                    {{-- MATERIAL --}}

                    <div class="customer-product-option">

                        <div class="customer-product-option__label">

                            <strong>
                                Material
                            </strong>

                        </div>


                        <div class="customer-product-option__values">


                            <label>

                                <input
                                    type="radio"
                                    name="material"
                                    value="cotton"
                                    checked
                                >

                                <span>
                                Cotton
                            </span>

                            </label>


                            <label>

                                <input
                                    type="radio"
                                    name="material"
                                    value="premium-cotton"
                                >

                                <span>
                                Premium Cotton
                            </span>

                            </label>


                        </div>

                    </div>


                </div>


                {{-- ======================================================== --}}
                {{-- PURCHASE --}}
                {{-- ======================================================== --}}

                <div class="customer-product-purchase">


                    {{-- QUANTITY --}}

                    <div class="customer-product-quantity">

                        <button
                            type="button"
                            data-quantity-minus
                            aria-label="Decrease quantity"
                        >

                            <i class="ri-subtract-line"></i>

                        </button>


                        <input
                            type="number"
                            name="quantity"
                            value="1"
                            min="1"
                            max="18"
                            data-product-quantity
                        >


                        <button
                            type="button"
                            data-quantity-plus
                            aria-label="Increase quantity"
                        >

                            <i class="ri-add-line"></i>

                        </button>

                    </div>


                    {{-- ADD TO CART --}}

                    <button
                        type="button"
                        class="customer-product-add-cart"
                        data-add-to-cart
                    >

                        <i class="ri-shopping-cart-2-line"></i>

                        <span>
                        Add to Cart
                    </span>

                    </button>


                    {{-- BUY NOW --}}

                    <a
                        href="{{ route('checkout') }}"
                        class="customer-product-buy-now"
                    >

                        Buy Now

                    </a>


                    {{-- WISHLIST --}}

                    <button
                        type="button"
                        class="customer-product-wishlist"
                        aria-label="Add to wishlist"
                        data-wishlist
                    >

                        <i class="ri-heart-line"></i>

                    </button>


                </div>


                {{-- ======================================================== --}}
                {{-- PRODUCT BENEFITS --}}
                {{-- ======================================================== --}}

                <div class="customer-product-benefits">


                    {{-- SHIPPING --}}

                    <div class="customer-product-benefit">

                        <div class="customer-product-benefit__icon">

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


                    {{-- RETURNS --}}

                    <div class="customer-product-benefit">

                        <div class="customer-product-benefit__icon">

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


                    {{-- SECURITY --}}

                    <div class="customer-product-benefit">

                        <div class="customer-product-benefit__icon">

                            <i class="ri-shield-check-line"></i>

                        </div>


                        <div>

                            <strong>
                                Secure Shopping
                            </strong>

                            <span>
                            Safe & secure checkout
                        </span>

                        </div>

                    </div>


                </div>


            </div>

        </div>


        {{-- ================================================================ --}}
        {{-- PRODUCT INFORMATION TABS --}}
        {{-- ================================================================ --}}

        <div
            class="customer-product-tabs"
            data-product-tabs
        >


            {{-- ============================================================ --}}
            {{-- TAB NAVIGATION --}}
            {{-- ============================================================ --}}

            <div
                class="customer-product-tabs__nav"
                role="tablist"
                aria-label="Product information"
            >


                {{-- DESCRIPTION TAB --}}

                <button
                    type="button"
                    id="product-tab-description"
                    class="customer-product-tab active"
                    data-tab="description"
                    role="tab"
                    aria-selected="true"
                    aria-controls="product-panel-description"
                    tabindex="0"
                >

                    <i class="ri-file-text-line"></i>

                    <span>
                    Description
                </span>

                </button>


                {{-- SPECIFICATIONS TAB --}}

                <button
                    type="button"
                    id="product-tab-specifications"
                    class="customer-product-tab"
                    data-tab="specifications"
                    role="tab"
                    aria-selected="false"
                    aria-controls="product-panel-specifications"
                    tabindex="-1"
                >

                    <i class="ri-list-check-2"></i>

                    <span>
                    Specifications
                </span>

                </button>


                {{-- SHIPPING TAB --}}

                <button
                    type="button"
                    id="product-tab-shipping"
                    class="customer-product-tab"
                    data-tab="shipping"
                    role="tab"
                    aria-selected="false"
                    aria-controls="product-panel-shipping"
                    tabindex="-1"
                >

                    <i class="ri-truck-line"></i>

                    <span>
                    Shipping
                </span>

                </button>


                {{-- REVIEWS TAB --}}

                <button
                    type="button"
                    id="product-tab-reviews"
                    class="customer-product-tab"
                    data-tab="reviews"
                    role="tab"
                    aria-selected="false"
                    aria-controls="product-panel-reviews"
                    tabindex="-1"
                >

                    <i class="ri-star-line"></i>

                    <span>
                    Reviews
                </span>

                    <b>
                        24
                    </b>

                </button>


            </div>


            {{-- ============================================================ --}}
            {{-- TAB CONTENT --}}
            {{-- ============================================================ --}}

            <div class="customer-product-tabs__content">


                {{-- ======================================================== --}}
                {{-- DESCRIPTION --}}
                {{-- ======================================================== --}}

                <div
                    id="product-panel-description"
                    class="customer-product-tab-panel active"
                    data-panel="description"
                    role="tabpanel"
                    aria-labelledby="product-tab-description"
                >

                    <div class="customer-product-description">


                        <div class="customer-product-tab-panel__heading">

                        <span>
                            About this product
                        </span>

                            <h2>
                                Product Description
                            </h2>

                        </div>


                        <p>
                            Our Premium Cotton T-Shirt is made for customers who value
                            comfort, quality and timeless style. The breathable cotton
                            fabric makes it suitable for everyday wear while maintaining
                            a clean and premium appearance.
                        </p>


                        <p>
                            Designed with a comfortable fit and durable stitching,
                            this t-shirt is easy to maintain and built for regular use.
                        </p>


                        <div class="customer-product-description__features">


                            <div>

                                <i class="ri-check-line"></i>

                                <span>
                                Premium cotton fabric
                            </span>

                            </div>


                            <div>

                                <i class="ri-check-line"></i>

                                <span>
                                Soft and breathable material
                            </span>

                            </div>


                            <div>

                                <i class="ri-check-line"></i>

                                <span>
                                Comfortable everyday fit
                            </span>

                            </div>


                            <div>

                                <i class="ri-check-line"></i>

                                <span>
                                Durable stitching
                            </span>

                            </div>


                            <div>

                                <i class="ri-check-line"></i>

                                <span>
                                Machine washable
                            </span>

                            </div>


                        </div>

                    </div>

                </div>


                {{-- ======================================================== --}}
                {{-- SPECIFICATIONS --}}
                {{-- ======================================================== --}}

                <div
                    id="product-panel-specifications"
                    class="customer-product-tab-panel"
                    data-panel="specifications"
                    role="tabpanel"
                    aria-labelledby="product-tab-specifications"
                    hidden
                >

                    <div class="customer-product-specifications">


                        <div class="customer-product-tab-panel__heading">

                        <span>
                            Product details
                        </span>

                            <h2>
                                Specifications
                            </h2>

                        </div>


                        <div class="customer-product-spec-table">


                            <div>

                            <span>
                                Brand
                            </span>

                                <strong>
                                    Brand One
                                </strong>

                            </div>


                            <div>

                            <span>
                                SKU
                            </span>

                                <strong>
                                    TS-001
                                </strong>

                            </div>


                            <div>

                            <span>
                                Material
                            </span>

                                <strong>
                                    Premium Cotton
                                </strong>

                            </div>


                            <div>

                            <span>
                                Weight
                            </span>

                                <strong>
                                    0.35 kg
                                </strong>

                            </div>


                            <div>

                            <span>
                                Available Sizes
                            </span>

                                <strong>
                                    S, M, L, XL
                                </strong>

                            </div>


                            <div>

                            <span>
                                Available Colors
                            </span>

                                <strong>
                                    Black, White, Blue, Gray
                                </strong>

                            </div>


                        </div>

                    </div>

                </div>


                {{-- ======================================================== --}}
                {{-- SHIPPING --}}
                {{-- ======================================================== --}}

                <div
                    id="product-panel-shipping"
                    class="customer-product-tab-panel"
                    data-panel="shipping"
                    role="tabpanel"
                    aria-labelledby="product-tab-shipping"
                    hidden
                >

                    <div class="customer-product-shipping-info">


                        <div class="customer-product-tab-panel__heading">

                        <span>
                            Delivery information
                        </span>

                            <h2>
                                Shipping Information
                            </h2>

                        </div>


                        <p>
                            Orders are processed within 1–2 business days.
                            Delivery time depends on your selected shipping method
                            and destination.
                        </p>


                        <div class="customer-product-shipping-grid">


                            <div>

                                <div class="customer-product-shipping-grid__icon">

                                    <i class="ri-truck-line"></i>

                                </div>

                                <strong>
                                    Standard Shipping
                                </strong>

                                <span>
                                3–7 business days
                            </span>

                            </div>


                            <div>

                                <div class="customer-product-shipping-grid__icon">

                                    <i class="ri-flashlight-line"></i>

                                </div>

                                <strong>
                                    Express Shipping
                                </strong>

                                <span>
                                1–3 business days
                            </span>

                            </div>


                            <div>

                                <div class="customer-product-shipping-grid__icon">

                                    <i class="ri-map-pin-line"></i>

                                </div>

                                <strong>
                                    Order Tracking
                                </strong>

                                <span>
                                Tracking available after shipment
                            </span>

                            </div>


                        </div>

                    </div>

                </div>


                {{-- ======================================================== --}}
                {{-- REVIEWS --}}
                {{-- ======================================================== --}}

                <div
                    id="product-panel-reviews"
                    class="customer-product-tab-panel"
                    data-panel="reviews"
                    role="tabpanel"
                    aria-labelledby="product-tab-reviews"
                    hidden
                >

                    <div
                        class="customer-product-reviews"
                        id="product-reviews"
                    >


                        <div class="customer-product-reviews__header">


                            <div>

                                <div class="customer-product-tab-panel__heading">

                                <span>
                                    Customer feedback
                                </span>

                                    <h2>
                                        Customer Reviews
                                    </h2>

                                </div>


                                <div class="customer-product-reviews__rating">

                                    <strong>
                                        4.8
                                    </strong>

                                    <span>
                                    ★★★★★
                                </span>

                                    <small>
                                        Based on 24 reviews
                                    </small>

                                </div>

                            </div>


                            <button
                                type="button"
                                class="customer-product-review-btn"
                            >

                                <i class="ri-edit-line"></i>

                                Write a Review

                            </button>


                        </div>


                        <div class="customer-product-review-list">


                            {{-- REVIEW 1 --}}

                            <article class="customer-product-review">


                                <div class="customer-product-review__top">


                                    <div class="customer-product-review__avatar">
                                        JD
                                    </div>


                                    <div class="customer-product-review__author">

                                        <strong>
                                            John Doe
                                        </strong>

                                        <span>
                                        Verified Purchase
                                    </span>

                                    </div>


                                    <div class="customer-product-review__stars">
                                        ★★★★★
                                    </div>


                                </div>


                                <h3>
                                    Great quality and comfortable
                                </h3>


                                <p>
                                    Really happy with the quality. The material feels
                                    premium and the fit is exactly what I expected.
                                </p>


                            </article>


                            {{-- REVIEW 2 --}}

                            <article class="customer-product-review">


                                <div class="customer-product-review__top">


                                    <div class="customer-product-review__avatar">
                                        SM
                                    </div>


                                    <div class="customer-product-review__author">

                                        <strong>
                                            Sarah Miller
                                        </strong>

                                        <span>
                                        Verified Purchase
                                    </span>

                                    </div>


                                    <div class="customer-product-review__stars">
                                        ★★★★★
                                    </div>


                                </div>


                                <h3>
                                    Excellent product
                                </h3>


                                <p>
                                    Very comfortable and looks great. I would definitely
                                    recommend this product.
                                </p>


                            </article>


                        </div>

                    </div>

                </div>


            </div>

        </div>


        {{-- ================================================================ --}}
        {{-- RELATED PRODUCTS --}}
        {{-- ================================================================ --}}

        <section class="customer-related-products">


            <div class="customer-related-products__header">


                <div>

                <span>
                    You May Also Like
                </span>

                    <h2>
                        Related Products
                    </h2>

                </div>


                <a href="{{ route('customer-shop') }}">

                    View All

                    <i class="ri-arrow-right-line"></i>

                </a>


            </div>


            <div class="customer-related-products__grid">


                {{-- PRODUCT 1 --}}

                <article class="customer-related-product">


                    <a
                        href="{{ route('customer-product-details', ['product' => 1]) }}"
                        class="customer-related-product__image"
                    >

                        <img
                            src="https://placehold.co/500x580"
                            alt="Classic Leather Wallet"
                        >


                        <button
                            type="button"
                            aria-label="Add to wishlist"
                            data-wishlist
                            onclick="event.preventDefault();"
                        >

                            <i class="ri-heart-line"></i>

                        </button>

                    </a>


                    <div class="customer-related-product__content">

                    <span>
                        Accessories
                    </span>

                        <h3>
                            Classic Leather Wallet
                        </h3>

                        <strong>
                            $49.99
                        </strong>

                    </div>


                </article>


                {{-- PRODUCT 2 --}}

                <article class="customer-related-product">


                    <a
                        href="{{ route('customer-product-details', ['product' => 2]) }}"
                        class="customer-related-product__image"
                    >

                        <img
                            src="https://placehold.co/500x580"
                            alt="Everyday Backpack"
                        >


                        <button
                            type="button"
                            aria-label="Add to wishlist"
                            data-wishlist
                            onclick="event.preventDefault();"
                        >

                            <i class="ri-heart-line"></i>

                        </button>

                    </a>


                    <div class="customer-related-product__content">

                    <span>
                        Accessories
                    </span>

                        <h3>
                            Everyday Backpack
                        </h3>

                        <strong>
                            $54.99
                        </strong>

                    </div>


                </article>


                {{-- PRODUCT 3 --}}

                <article class="customer-related-product">


                    <a
                        href="{{ route('customer-product-details', ['product' => 3]) }}"
                        class="customer-related-product__image"
                    >

                        <img
                            src="https://placehold.co/500x580"
                            alt="Oversized Hoodie"
                        >


                        <button
                            type="button"
                            aria-label="Add to wishlist"
                            data-wishlist
                            onclick="event.preventDefault();"
                        >

                            <i class="ri-heart-line"></i>

                        </button>

                    </a>


                    <div class="customer-related-product__content">

                    <span>
                        Clothing
                    </span>

                        <h3>
                            Oversized Hoodie
                        </h3>

                        <strong>
                            $64.99
                        </strong>

                    </div>


                </article>


                {{-- PRODUCT 4 --}}

                <article class="customer-related-product">


                    <a
                        href="{{ route('customer-product-details', ['product' => 4]) }}"
                        class="customer-related-product__image"
                    >

                        <img
                            src="https://placehold.co/500x580"
                            alt="Daily Face Moisturizer"
                        >


                        <button
                            type="button"
                            aria-label="Add to wishlist"
                            data-wishlist
                            onclick="event.preventDefault();"
                        >

                            <i class="ri-heart-line"></i>

                        </button>

                    </a>


                    <div class="customer-related-product__content">

                    <span>
                        Beauty
                    </span>

                        <h3>
                            Daily Face Moisturizer
                        </h3>

                        <strong>
                            $34.99
                        </strong>

                    </div>


                </article>


            </div>

        </section>


    </div>


    {{-- ================================================================ --}}
    {{-- PRODUCT DETAILS JAVASCRIPT --}}
    {{-- ================================================================ --}}

    @push('scripts')

        <script>

            document.addEventListener('DOMContentLoaded', function () {


                /*
                |--------------------------------------------------------------------------
                | PRODUCT IMAGE GALLERY
                |--------------------------------------------------------------------------
                */

                const mainImage =
                    document.getElementById(
                        'customerProductMainImage'
                    );


                const thumbnails =
                    document.querySelectorAll(
                        '.customer-product-thumbnail'
                    );


                thumbnails.forEach(function (thumbnail) {


                    thumbnail.addEventListener(
                        'click',
                        function () {


                            if (!mainImage) {
                                return;
                            }


                            const image =
                                thumbnail.dataset.productImage;


                            if (!image) {
                                return;
                            }


                            thumbnails.forEach(function (item) {

                                item.classList.remove(
                                    'active'
                                );

                            });


                            thumbnail.classList.add(
                                'active'
                            );


                            mainImage.style.opacity = '0';


                            setTimeout(function () {

                                mainImage.src = image;

                                mainImage.style.opacity = '1';

                            }, 120);


                        }
                    );


                });


                /*
                |--------------------------------------------------------------------------
                | QUANTITY
                |--------------------------------------------------------------------------
                */

                const quantityInput =
                    document.querySelector(
                        '[data-product-quantity]'
                    );


                const quantityMinus =
                    document.querySelector(
                        '[data-quantity-minus]'
                    );


                const quantityPlus =
                    document.querySelector(
                        '[data-quantity-plus]'
                    );


                if (quantityInput) {


                    quantityInput.addEventListener(
                        'input',
                        function () {

                            let value =
                                parseInt(
                                    quantityInput.value
                                ) || 1;


                            const min =
                                parseInt(
                                    quantityInput.min
                                ) || 1;


                            const max =
                                parseInt(
                                    quantityInput.max
                                ) || 999;


                            if (value < min) {
                                value = min;
                            }


                            if (value > max) {
                                value = max;
                            }


                            quantityInput.value =
                                value;

                        }
                    );

                }


                if (quantityMinus) {


                    quantityMinus.addEventListener(
                        'click',
                        function () {


                            if (!quantityInput) {
                                return;
                            }


                            let value =
                                parseInt(
                                    quantityInput.value
                                ) || 1;


                            const min =
                                parseInt(
                                    quantityInput.min
                                ) || 1;


                            if (value > min) {

                                quantityInput.value =
                                    value - 1;

                            }

                        }
                    );

                }


                if (quantityPlus) {


                    quantityPlus.addEventListener(
                        'click',
                        function () {


                            if (!quantityInput) {
                                return;
                            }


                            let value =
                                parseInt(
                                    quantityInput.value
                                ) || 1;


                            const max =
                                parseInt(
                                    quantityInput.max
                                ) || 999;


                            if (value < max) {

                                quantityInput.value =
                                    value + 1;

                            }

                        }
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | PRODUCT TABS
                |--------------------------------------------------------------------------
                */

                const tabContainer =
                    document.querySelector(
                        '[data-product-tabs]'
                    );


                if (!tabContainer) {
                    return;
                }


                const tabs =
                    Array.from(
                        tabContainer.querySelectorAll(
                            '[role="tab"]'
                        )
                    );


                const panels =
                    Array.from(
                        tabContainer.querySelectorAll(
                            '[role="tabpanel"]'
                        )
                    );


                function activateTab(
                    tab,
                    moveFocus = false
                ) {


                    if (!tab) {
                        return;
                    }


                    const target =
                        tab.dataset.tab;


                    if (!target) {
                        return;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | TAB STATE
                    |--------------------------------------------------------------------------
                    */

                    tabs.forEach(function (item) {


                        const active =
                            item === tab;


                        item.classList.toggle(
                            'active',
                            active
                        );


                        item.setAttribute(
                            'aria-selected',
                            active
                                ? 'true'
                                : 'false'
                        );


                        item.tabIndex =
                            active
                                ? 0
                                : -1;


                    });


                    /*
                    |--------------------------------------------------------------------------
                    | PANEL STATE
                    |--------------------------------------------------------------------------
                    */

                    panels.forEach(function (panel) {


                        const active =
                            panel.dataset.panel === target;


                        panel.hidden =
                            !active;


                        panel.classList.toggle(
                            'active',
                            active
                        );


                    });


                    /*
                    |--------------------------------------------------------------------------
                    | FOCUS
                    |--------------------------------------------------------------------------
                    */

                    if (moveFocus) {

                        tab.focus();

                    }


                }


                /*
                |--------------------------------------------------------------------------
                | TAB CLICK
                |--------------------------------------------------------------------------
                */

                tabs.forEach(function (tab) {


                    tab.addEventListener(
                        'click',
                        function () {

                            activateTab(tab);

                        }
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | KEYBOARD NAVIGATION
                    |--------------------------------------------------------------------------
                    */

                    tab.addEventListener(
                        'keydown',
                        function (event) {


                            const currentIndex =
                                tabs.indexOf(tab);


                            let nextIndex;


                            if (
                                event.key ===
                                'ArrowRight'
                            ) {

                                event.preventDefault();


                                nextIndex =
                                    (
                                        currentIndex + 1
                                    ) %
                                    tabs.length;


                                activateTab(
                                    tabs[nextIndex],
                                    true
                                );

                            }


                            if (
                                event.key ===
                                'ArrowLeft'
                            ) {

                                event.preventDefault();


                                nextIndex =
                                    (
                                        currentIndex - 1 +
                                        tabs.length
                                    ) %
                                    tabs.length;


                                activateTab(
                                    tabs[nextIndex],
                                    true
                                );

                            }


                            if (
                                event.key ===
                                'Home'
                            ) {

                                event.preventDefault();


                                activateTab(
                                    tabs[0],
                                    true
                                );

                            }


                            if (
                                event.key ===
                                'End'
                            ) {

                                event.preventDefault();


                                activateTab(
                                    tabs[tabs.length - 1],
                                    true
                                );

                            }


                        }
                    );


                });


                /*
                |--------------------------------------------------------------------------
                | REVIEW LINK
                |--------------------------------------------------------------------------
                */

                const reviewLinks =
                    document.querySelectorAll(
                        '[data-open-product-tab="reviews"]'
                    );


                reviewLinks.forEach(function (link) {


                    link.addEventListener(
                        'click',
                        function (event) {


                            event.preventDefault();


                            const reviewsTab =
                                tabs.find(
                                    function (tab) {

                                        return (
                                            tab.dataset.tab ===
                                            'reviews'
                                        );

                                    }
                                );


                            if (!reviewsTab) {
                                return;
                            }


                            activateTab(
                                reviewsTab
                            );


                            setTimeout(
                                function () {


                                    const section =
                                        tabContainer.getBoundingClientRect();


                                    const scrollTop =
                                        window.scrollY +
                                        section.top -
                                        25;


                                    window.scrollTo({

                                        top: scrollTop,

                                        behavior:
                                            'smooth'

                                    });


                                },
                                50
                            );


                        }
                    );


                });


                /*
                |--------------------------------------------------------------------------
                | WISHLIST
                |--------------------------------------------------------------------------
                */

                const wishlistButtons =
                    document.querySelectorAll(
                        '[data-wishlist]'
                    );


                wishlistButtons.forEach(
                    function (button) {


                        button.addEventListener(
                            'click',
                            function (event) {


                                event.preventDefault();


                                const icon =
                                    button.querySelector(
                                        'i'
                                    );


                                if (!icon) {
                                    return;
                                }


                                const active =
                                    button.classList.toggle(
                                        'is-active'
                                    );


                                icon.className =
                                    active
                                        ? 'ri-heart-fill'
                                        : 'ri-heart-line';


                            }
                        );


                    }
                );


                /*
                |--------------------------------------------------------------------------
                | ADD TO CART UI
                |--------------------------------------------------------------------------
                */

                const addToCart =
                    document.querySelector(
                        '[data-add-to-cart]'
                    );


                if (addToCart) {


                    addToCart.addEventListener(
                        'click',
                        function () {


                            const original =
                                addToCart.innerHTML;


                            addToCart.innerHTML = `
                    <i class="ri-check-line"></i>
                    <span>Added to Cart</span>
                `;


                            addToCart.classList.add(
                                'is-added'
                            );


                            setTimeout(
                                function () {


                                    addToCart.innerHTML =
                                        original;


                                    addToCart.classList.remove(
                                        'is-added'
                                    );


                                },
                                1500
                            );


                        }
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | INITIAL TAB
                |--------------------------------------------------------------------------
                */

                const initialTab =
                    tabs.find(
                        function (tab) {

                            return tab.classList.contains(
                                'active'
                            );

                        }
                    ) || tabs[0];


                if (initialTab) {

                    activateTab(
                        initialTab
                    );

                }


            });

        </script>

    @endpush

@endsection
