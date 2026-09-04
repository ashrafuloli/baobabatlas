@extends('frontend.layouts.frontend')

@section('contents')

    <div class="my-wishlist-page">

        <!--================================
            Wishlist Header
        =================================-->

        <section class="my-wishlist-page__section">

            <div class="container">

                <div class="my-wishlist-page__header">

                    <div class="my-wishlist-page__header-content">

                        <span class="my-wishlist-page__eyebrow">
                            My Account
                        </span>

                        <h1 class="my-wishlist-page__title">
                            My Wishlist
                        </h1>

                        <p class="my-wishlist-page__description">
                            Save your favorite products and easily
                            add them to your cart whenever you're ready.
                        </p>

                    </div>

                    <a
                        href="{{ url('/shop') }}"
                        class="my-wishlist-page__continue-btn"
                    >
                        <i class="ri-arrow-left-line"></i>
                        <span>Continue Shopping</span>
                    </a>

                </div>


                <!--================================
                    Wishlist Content
                =================================-->

                <div class="my-wishlist-page__content">

                    <div class="my-wishlist-page__topbar">

                        <div class="my-wishlist-page__count">
                            <strong class="wishlist-count">
                                4
                            </strong>

                            <span>
                                Items in Wishlist
                            </span>
                        </div>

                        <button
                            type="button"
                            class="my-wishlist-page__clear-btn"
                        >
                            <i class="ri-delete-bin-line"></i>
                            <span>Clear Wishlist</span>
                        </button>

                    </div>


                    <!--================================
                        Wishlist Products
                    =================================-->

                    <div class="product-grid related">


                        <div class="product-card">

                            <div class="product-image">

                                    <span class="product-badge bestseller">
                                        BEST SELLER
                                    </span>

                                <button type="button" class="wishlist is-active">
                                    <i class="ri-heart-fill"></i>
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

                                <button type="button" class="wishlist is-active">
                                    <i class="ri-heart-fill"></i>
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

                                <button type="button" class="wishlist is-active">
                                    <i class="ri-heart-fill"></i>
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

                    </div>


                    <!--================================
                        Empty Wishlist
                    =================================-->

                    <div
                        class="my-wishlist-page__empty"
                        hidden
                    >

                        <div class="my-wishlist-page__empty-icon">

                            <i class="ri-heart-3-line"></i>

                        </div>

                        <h2>
                            Your Wishlist is Empty
                        </h2>

                        <p>
                            You haven't added any products
                            to your wishlist yet.
                        </p>

                        <a
                            href="{{ url('/shop') }}"
                            class="my-wishlist-page__empty-btn"
                        >
                            Explore Products
                        </a>

                    </div>

                </div>

            </div>

        </section>

    </div>

    <script>
        (function () {

            const initWishlist = function () {

                const wishlistPage =
                    document.querySelector(
                        '.my-wishlist-page'
                    );


                if (!wishlistPage) {
                    return;
                }


                /*
                =====================================
                    Elements
                =====================================
                */

                const productGrid =
                    wishlistPage.querySelector(
                        '.product-grid.related'
                    );


                const countElement =
                    wishlistPage.querySelector(
                        '.wishlist-count'
                    );


                const emptyState =
                    wishlistPage.querySelector(
                        '.my-wishlist-page__empty'
                    );


                const clearButton =
                    wishlistPage.querySelector(
                        '.my-wishlist-page__clear-btn'
                    );


                /*
                =====================================
                    Get Product Cards
                =====================================
                */

                const getProductCards = function () {

                    if (!productGrid) {
                        return [];
                    }


                    return Array.from(
                        productGrid.querySelectorAll(
                            '.product-card'
                        )
                    );

                };


                /*
                =====================================
                    Update Wishlist State
                =====================================
                */

                const updateWishlistState = function () {

                    const productCards =
                        getProductCards();


                    const count =
                        productCards.length;


                    /*
                    Update Count
                    */

                    if (countElement) {

                        countElement.textContent =
                            count;

                    }


                    /*
                    Show / Hide Product Grid
                    */

                    if (productGrid) {

                        productGrid.hidden =
                            count === 0;

                    }


                    /*
                    Show / Hide Empty State
                    */

                    if (emptyState) {

                        emptyState.hidden =
                            count !== 0;

                    }


                    /*
                    Show / Hide Clear Button
                    */

                    if (clearButton) {

                        clearButton.hidden =
                            count === 0;

                    }

                };


                /*
                =====================================
                    Wishlist Heart
                =====================================
                */

                wishlistPage
                    .querySelectorAll(
                        '.product-card .wishlist'
                    )
                    .forEach(function (wishlistButton) {

                        wishlistButton.addEventListener(
                            'click',
                            function () {

                                const productCard =
                                    wishlistButton.closest(
                                        '.product-card'
                                    );


                                if (!productCard) {
                                    return;
                                }


                                /*
                                Remove Product
                                */

                                productCard.remove();


                                /*
                                Update Wishlist
                                */

                                updateWishlistState();

                            }
                        );

                    });


                /*
                =====================================
                    Clear Wishlist
                =====================================
                */

                if (clearButton) {

                    clearButton.addEventListener(
                        'click',
                        function () {

                            const productCards =
                                getProductCards();


                            productCards.forEach(
                                function (productCard) {

                                    productCard.remove();

                                }
                            );


                            updateWishlistState();

                        }
                    );

                }


                /*
                =====================================
                    Initial State
                =====================================
                */

                updateWishlistState();

            };


            /*
            =====================================
                Initialize
            =====================================
            */

            if (
                document.readyState === 'loading'
            ) {

                document.addEventListener(
                    'DOMContentLoaded',
                    initWishlist
                );

            } else {

                initWishlist();

            }

        })();
    </script>

@endsection
