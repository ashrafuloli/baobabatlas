@extends('frontend.layouts.frontend')

    @section('contents')

        <div class="product-details-page">

            {{-- Breadcrumb --}}
            <div class="product-breadcrumb">
                <div class="container">

                    <ul>
                        <li>
                            <a href="#">
                                Shop
                            </a>
                        </li>

                        <li>
                            <i class="ri-arrow-right-s-line"></i>
                        </li>

                        <li>
                            <a href="#">
                                Clothing
                            </a>
                        </li>

                        <li>
                            <i class="ri-arrow-right-s-line"></i>
                        </li>

                        <li>
                        <span>
                            Premium Cotton T-Shirt
                        </span>
                        </li>
                    </ul>

                </div>
            </div>


            {{-- Product Details --}}
            <section class="product-details-section">

                <div class="container">

                    <div class="product-details-wrapper">


                        {{-- Product Gallery --}}
                        <div class="product-gallery">

                            <div class="product-gallery-thumbnails">

                                <button
                                    type="button"
                                    class="product-thumbnail is-active"
                                    data-image="{{ asset('assets/img/products/thumb-1.jpeg') }}"
                                >
                                    <img
                                        src="{{ asset('assets/img/products/thumb-1.jpeg') }}"
                                        alt="Premium Cotton T-Shirt Front"
                                    >
                                </button>

                                <button
                                    type="button"
                                    class="product-thumbnail"
                                    data-image="{{ asset('assets/img/products/thumb-2.jpeg') }}"
                                >
                                    <img
                                        src="{{ asset('assets/img/products/thumb-2.jpeg') }}"
                                        alt="Premium Cotton T-Shirt Side"
                                    >
                                </button>

                                <button
                                    type="button"
                                    class="product-thumbnail"
                                    data-image="{{ asset('assets/img/products/thumb-3.jpeg') }}"
                                >
                                    <img
                                        src="{{ asset('assets/img/products/thumb-3.jpeg') }}"
                                        alt="Premium Cotton T-Shirt Back"
                                    >
                                </button>

                                <button
                                    type="button"
                                    class="product-thumbnail"
                                    data-image="{{ asset('assets/img/products/thumb-1.jpeg') }}"
                                >
                                    <img
                                        src="{{ asset('assets/img/products/thumb-1.jpeg') }}"
                                        alt="Premium Cotton T-Shirt Detail"
                                    >
                                </button>

                            </div>


                            <div class="product-main-image">

                            <span class="product-sale-tag">
                                Sale
                            </span>

                                <img
                                    class="product-main-image-element"
                                    src="{{ asset('assets/img/products/thumb-1.jpeg') }}"
                                    alt="Premium Cotton T-Shirt"
                                >

                                <button
                                    type="button"
                                    class="product-image-zoom"
                                    aria-label="Zoom product image"
                                >
                                    <i class="ri-search-line"></i>
                                </button>

                            </div>

                        </div>


                        {{-- Product Information --}}
                        <div class="product-information">

                        <span class="product-category">
                            Clothing
                        </span>


                            <h1>
                                Premium Cotton T-Shirt
                            </h1>


                            <div class="product-rating-row">

                                <div class="product-stars">

                                    <i class="ri-star-fill"></i>
                                    <i class="ri-star-fill"></i>
                                    <i class="ri-star-fill"></i>
                                    <i class="ri-star-fill"></i>
                                    <i class="ri-star-fill"></i>

                                </div>

                                <a href="#product-reviews">
                                    24 Reviews
                                </a>

                                <span class="product-sku">
                                SKU: TS-001
                            </span>

                            </div>


                            <div class="product-price-row">

                            <span class="old-price">
                                $39.99
                            </span>

                                <strong>
                                    $29.99
                                </strong>

                                <span class="discount-badge">
                                25% OFF
                            </span>

                            </div>


                            <p class="product-short-description">
                                Premium quality cotton t-shirt designed for everyday comfort.
                                Soft, breathable and made with durable fabric for long-lasting use.
                            </p>


                            <div class="product-stock">

                                <i class="ri-checkbox-circle-fill"></i>

                                <strong>
                                    In Stock
                                </strong>

                                <span>
                                18 items available
                            </span>

                            </div>


                            {{-- Size --}}
                            <div class="product-option-group">

                                <div class="product-option-header">

                                <span>
                                    Size
                                </span>

                                    <small>
                                        Select Size
                                    </small>

                                </div>


                                <div class="product-option-list product-size-list">

                                    <button
                                        type="button"
                                        class="product-option"
                                        data-size="S"
                                    >
                                        S
                                    </button>

                                    <button
                                        type="button"
                                        class="product-option is-selected"
                                        data-size="M"
                                    >
                                        M
                                    </button>

                                    <button
                                        type="button"
                                        class="product-option"
                                        data-size="L"
                                    >
                                        L
                                    </button>

                                    <button
                                        type="button"
                                        class="product-option"
                                        data-size="XL"
                                    >
                                        XL
                                    </button>

                                </div>

                            </div>


                            {{-- Color --}}
                            <div class="product-option-group">

                                <div class="product-option-header">

                                <span>
                                    Color
                                </span>

                                    <small>
                                        Select Color
                                    </small>

                                </div>


                                <div class="product-color-list">

                                    <button
                                        type="button"
                                        class="product-color is-selected"
                                        data-color="Black"
                                        aria-label="Black"
                                    >
                                        <span class="color-black"></span>
                                    </button>

                                    <button
                                        type="button"
                                        class="product-color"
                                        data-color="White"
                                        aria-label="White"
                                    >
                                        <span class="color-white"></span>
                                    </button>

                                    <button
                                        type="button"
                                        class="product-color"
                                        data-color="Blue"
                                        aria-label="Blue"
                                    >
                                        <span class="color-blue"></span>
                                    </button>

                                    <button
                                        type="button"
                                        class="product-color"
                                        data-color="Gray"
                                        aria-label="Gray"
                                    >
                                        <span class="color-gray"></span>
                                    </button>

                                </div>

                            </div>


                            <div class="product-action-row">


                                {{-- Quantity --}}
                                <div class="product-quantity">

                                    <button
                                        type="button"
                                        class="quantity-minus"
                                    >
                                        <i class="ri-subtract-line"></i>
                                    </button>

                                    <input
                                        type="number"
                                        class="quantity-input"
                                        value="1"
                                        min="1"
                                    >

                                    <button
                                        type="button"
                                        class="quantity-plus"
                                    >
                                        <i class="ri-add-line"></i>
                                    </button>

                                </div>


                                {{-- Add To Cart --}}
                                <button
                                    type="button"
                                    class="product-add-cart"
                                >
                                    <i class="ri-shopping-cart-line"></i>

                                    Add to Cart
                                </button>


                                {{-- Wishlist --}}
                                <button
                                    type="button"
                                    class="product-wishlist"
                                    aria-label="Add to wishlist"
                                >
                                    <i class="ri-heart-line"></i>
                                </button>

                            </div>


                            {{-- Benefits --}}
                            <div class="product-benefits">

                                <div class="product-benefit">

                                    <div class="product-benefit-icon">
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


                                <div class="product-benefit">

                                    <div class="product-benefit-icon">
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


                                <div class="product-benefit">

                                    <div class="product-benefit-icon">
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

                </div>

            </section>


            {{-- Product Tabs --}}
            <section class="product-content-section">

                <div class="container">

                    <div class="product-tabs">


                        {{-- Tab Navigation --}}
                        <div class="product-tab-navigation">

                            <button
                                type="button"
                                class="product-tab-button is-active"
                                data-tab="description"
                            >
                                <i class="ri-file-text-line"></i>

                                Description
                            </button>


                            <button
                                type="button"
                                class="product-tab-button"
                                data-tab="specifications"
                            >
                                <i class="ri-list-check-2"></i>

                                Specifications
                            </button>


                            <button
                                type="button"
                                class="product-tab-button"
                                data-tab="reviews"
                            >
                                <i class="ri-star-line"></i>

                                Reviews

                                <span>
                                24
                            </span>
                            </button>

                        </div>


                        {{-- Description --}}
                        <div
                            class="product-tab-panel is-active"
                            data-panel="description"
                        >

                            <div class="product-tab-content">

                            <span class="product-tab-eyebrow">
                                About This Product
                            </span>

                                <h2>
                                    Product Description
                                </h2>

                                <p>
                                    Our Premium Cotton T-Shirt is made for customers who value
                                    comfort, quality and timeless style. The breathable cotton
                                    fabric makes it suitable for everyday wear while maintaining
                                    a clean and premium appearance.
                                </p>

                                <p>
                                    Designed with a comfortable fit and durable stitching, this
                                    t-shirt is easy to maintain and built for regular use.
                                </p>


                                <div class="product-feature-list">

                                    <div>
                                        <i class="ri-check-line"></i>

                                        Premium cotton fabric
                                    </div>

                                    <div>
                                        <i class="ri-check-line"></i>

                                        Soft and breathable material
                                    </div>

                                    <div>
                                        <i class="ri-check-line"></i>

                                        Comfortable everyday fit
                                    </div>

                                    <div>
                                        <i class="ri-check-line"></i>

                                        Durable stitching
                                    </div>

                                    <div>
                                        <i class="ri-check-line"></i>

                                        Machine washable
                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- Specifications --}}
                        <div
                            class="product-tab-panel"
                            data-panel="specifications"
                        >

                            <div class="product-tab-content">

                            <span class="product-tab-eyebrow">
                                Product Details
                            </span>

                                <h2>
                                    Specifications
                                </h2>


                                <div class="product-specifications">

                                    <div class="product-specification-item">

                                    <span>
                                        Brand
                                    </span>

                                        <strong>
                                            Brand One
                                        </strong>

                                    </div>


                                    <div class="product-specification-item">

                                    <span>
                                        SKU
                                    </span>

                                        <strong>
                                            TS-001
                                        </strong>

                                    </div>


                                    <div class="product-specification-item">

                                    <span>
                                        Weight
                                    </span>

                                        <strong>
                                            0.35 kg
                                        </strong>

                                    </div>


                                    <div class="product-specification-item">

                                    <span>
                                        Available Sizes
                                    </span>

                                        <strong>
                                            S, M, L, XL
                                        </strong>

                                    </div>


                                    <div class="product-specification-item">

                                    <span>
                                        Available Colors
                                    </span>

                                        <strong>
                                            Black, White, Blue, Gray
                                        </strong>

                                    </div>


                                    <div class="product-specification-item">

                                    <span>
                                        Product Type
                                    </span>

                                        <strong>
                                            T-Shirt
                                        </strong>

                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- Reviews --}}
                        <div
                            class="product-tab-panel"
                            data-panel="reviews"
                            id="product-reviews"
                        >

                            <div class="product-tab-content">

                                <div class="product-review-heading">

                                    <div>

                                    <span class="product-tab-eyebrow">
                                        Customer Feedback
                                    </span>

                                        <h2>
                                            Customer Reviews
                                        </h2>

                                    </div>


                                    <button
                                        type="button"
                                        class="write-review-button"
                                    >
                                        <i class="ri-pencil-line"></i>

                                        Write a Review
                                    </button>

                                </div>


                                <div class="product-review-summary">

                                    <strong>
                                        4.8
                                    </strong>

                                    <div class="product-stars">

                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>

                                    </div>

                                    <span>
                                    Based on 24 reviews
                                </span>

                                </div>


                                <div class="product-review-list">


                                    <div class="product-review-card">

                                        <div class="product-review-top">

                                            <div class="product-review-user">

                                            <span>
                                                JD
                                            </span>

                                                <div>
                                                    <strong>
                                                        John Doe
                                                    </strong>

                                                    <small>
                                                        Verified Purchase
                                                    </small>
                                                </div>

                                            </div>


                                            <div class="product-stars">

                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>

                                            </div>

                                        </div>


                                        <h3>
                                            Great quality and comfortable
                                        </h3>

                                        <p>
                                            Really happy with the quality. The material feels
                                            premium and the fit is exactly what I expected.
                                        </p>

                                    </div>


                                    <div class="product-review-card">

                                        <div class="product-review-top">

                                            <div class="product-review-user">

                                            <span>
                                                SM
                                            </span>

                                                <div>
                                                    <strong>
                                                        Sarah Miller
                                                    </strong>

                                                    <small>
                                                        Verified Purchase
                                                    </small>
                                                </div>

                                            </div>


                                            <div class="product-stars">

                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>

                                            </div>

                                        </div>


                                        <h3>
                                            Excellent product
                                        </h3>

                                        <p>
                                            Very comfortable and looks great. I would definitely
                                            recommend this product.
                                        </p>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </section>


            {{-- Related Products --}}
            <section class="related-products-section">

                <div class="container">

                    <div class="related-products-heading">

                        <div>

                        <span>
                            You May Also Like
                        </span>

                            <h2>
                                Related Products
                            </h2>

                        </div>


                        <a href="#">
                            View All

                            <i class="ri-arrow-right-line"></i>
                        </a>

                    </div>


                    <div class="product-grid related">


                        <div class="product-card">

                            <div class="product-image">

                                    <span class="product-badge bestseller">
                                        BEST SELLER
                                    </span>

                                <button type="button" class="wishlist">
                                    <i class="ri-heart-line"></i>
                                </button>

                                <a href="#">
                                    <img
                                        src="{{ asset('assets/img/products/thumb-1.jpeg') }}"
                                        alt="Raw Cashew Nuts"
                                    >
                                </a>

                            </div>


                            <div class="product-content">

                                <h4>
                                    <a href="#">
                                        Raw Cashew Nuts
                                    </a>
                                </h4>

                                <strong class="product-price">
                                    $2.45
                                </strong>

                                <div class="product-rating">
                                    <span class="stars">★★★★★</span>
                                    <span>4.8 (120)</span>
                                </div>

                            </div>

                        </div>


                        <div class="product-card">

                            <div class="product-image">

                                    <span class="product-badge premium">
                                        PREMIUM
                                    </span>

                                <button type="button" class="wishlist">
                                    <i class="ri-heart-line"></i>
                                </button>

                                <a href="#">
                                    <img
                                        src="{{ asset('assets/img/products/thumb-2.jpeg') }}"
                                        alt="Gold Nuggets"
                                    >
                                </a>

                            </div>


                            <div class="product-content">

                                <h4>
                                    <a href="#">
                                        Gold Nuggets
                                    </a>
                                </h4>

                                <strong class="product-price">
                                    $58,500
                                </strong>

                                <div class="product-rating">
                                    <span class="stars">★★★★★</span>
                                    <span>4.9 (85)</span>
                                </div>

                            </div>

                        </div>


                        <div class="product-card">

                            <div class="product-image">

                                <button type="button" class="wishlist">
                                    <i class="ri-heart-line"></i>
                                </button>

                                <a href="#">
                                    <img
                                        src="{{ asset('assets/img/products/thumb-3.jpeg') }}"
                                        alt="African Wax Print Fabric"
                                    >
                                </a>

                            </div>


                            <div class="product-content">

                                <h4>
                                    <a href="#">
                                        African Wax Print Fabric
                                    </a>
                                </h4>

                                <strong class="product-price">
                                    $4.75
                                </strong>

                                <div class="product-rating">
                                    <span class="stars">★★★★★</span>
                                    <span>4.7 (60)</span>
                                </div>

                            </div>

                        </div>


                        <div class="product-card">

                            <div class="product-image">

                                    <span class="product-badge bestseller">
                                        BEST SELLER
                                    </span>

                                <button type="button" class="wishlist">
                                    <i class="ri-heart-line"></i>
                                </button>

                                <a href="#">
                                    <img
                                        src="{{ asset('assets/img/products/thumb-1.jpeg') }}"
                                        alt="Raw Cashew Nuts"
                                    >
                                </a>

                            </div>


                            <div class="product-content">

                                <h4>
                                    <a href="#">
                                        Raw Cashew Nuts
                                    </a>
                                </h4>

                                <strong class="product-price">
                                    $2.45
                                </strong>

                                <div class="product-rating">
                                    <span class="stars">★★★★★</span>
                                    <span>4.8 (120)</span>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </section>

        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {

                const productDetailsPage =
                    document.querySelector('.product-details-page');


                if (!productDetailsPage) {
                    return;
                }


                /*
                =====================================
                    Product Gallery
                =====================================
                */
                const mainImage =
                    productDetailsPage.querySelector(
                        '.product-main-image-element'
                    );


                const thumbnails =
                    productDetailsPage.querySelectorAll(
                        '.product-thumbnail'
                    );


                thumbnails.forEach(function (thumbnail) {

                    thumbnail.addEventListener('click', function () {

                        const image =
                            thumbnail.dataset.image;


                        if (!image || !mainImage) {
                            return;
                        }


                        mainImage.src =
                            image;


                        thumbnails.forEach(function (item) {

                            item.classList.remove(
                                'is-active'
                            );

                        });


                        thumbnail.classList.add(
                            'is-active'
                        );

                    });

                });


                /*
                =====================================
                    Product Tabs
                =====================================
                */
                const tabButtons =
                    productDetailsPage.querySelectorAll(
                        '.product-tab-button'
                    );


                const tabPanels =
                    productDetailsPage.querySelectorAll(
                        '.product-tab-panel'
                    );


                tabButtons.forEach(function (button) {

                    button.addEventListener('click', function () {

                        const targetTab =
                            button.dataset.tab;


                        tabButtons.forEach(function (item) {

                            item.classList.remove(
                                'is-active'
                            );

                        });


                        tabPanels.forEach(function (panel) {

                            panel.classList.remove(
                                'is-active'
                            );

                        });


                        button.classList.add(
                            'is-active'
                        );


                        const targetPanel =
                            productDetailsPage.querySelector(
                                '[data-panel="' +
                                targetTab +
                                '"]'
                            );


                        if (targetPanel) {

                            targetPanel.classList.add(
                                'is-active'
                            );

                        }

                    });

                });


                /*
                =====================================
                    Size Selection
                =====================================
                */
                const sizeOptions =
                    productDetailsPage.querySelectorAll(
                        '.product-size-list .product-option'
                    );


                sizeOptions.forEach(function (option) {

                    option.addEventListener('click', function () {

                        sizeOptions.forEach(function (item) {

                            item.classList.remove(
                                'is-selected'
                            );

                        });


                        option.classList.add(
                            'is-selected'
                        );

                    });

                });


                /*
                =====================================
                    Color Selection
                =====================================
                */
                const colorOptions =
                    productDetailsPage.querySelectorAll(
                        '.product-color'
                    );


                colorOptions.forEach(function (option) {

                    option.addEventListener('click', function () {

                        colorOptions.forEach(function (item) {

                            item.classList.remove(
                                'is-selected'
                            );

                        });


                        option.classList.add(
                            'is-selected'
                        );

                    });

                });


                /*
                =====================================
                    Quantity
                =====================================
                */
                const quantityInput =
                    productDetailsPage.querySelector(
                        '.quantity-input'
                    );


                const quantityMinus =
                    productDetailsPage.querySelector(
                        '.quantity-minus'
                    );


                const quantityPlus =
                    productDetailsPage.querySelector(
                        '.quantity-plus'
                    );


                if (
                    quantityInput &&
                    quantityMinus &&
                    quantityPlus
                ) {

                    quantityMinus.addEventListener(
                        'click',
                        function () {

                            let value =
                                parseInt(
                                    quantityInput.value,
                                    10
                                );


                            if (value > 1) {

                                quantityInput.value =
                                    value - 1;

                            }

                        }
                    );


                    quantityPlus.addEventListener(
                        'click',
                        function () {

                            let value =
                                parseInt(
                                    quantityInput.value,
                                    10
                                );


                            quantityInput.value =
                                value + 1;

                        }
                    );

                }


                /*
                =====================================
                    Wishlist
                =====================================
                */
                const wishlistButtons =
                    productDetailsPage.querySelectorAll(
                        '.product-wishlist, .product-card-wishlist'
                    );


                wishlistButtons.forEach(function (button) {

                    button.addEventListener('click', function () {

                        button.classList.toggle(
                            'is-active'
                        );


                        const icon =
                            button.querySelector('i');


                        if (!icon) {
                            return;
                        }


                        if (
                            button.classList.contains(
                                'is-active'
                            )
                        ) {

                            icon.classList.remove(
                                'ri-heart-line'
                            );

                            icon.classList.add(
                                'ri-heart-fill'
                            );

                        } else {

                            icon.classList.remove(
                                'ri-heart-fill'
                            );

                            icon.classList.add(
                                'ri-heart-line'
                            );

                        }

                    });

                });

            });
        </script>

    @endsection
