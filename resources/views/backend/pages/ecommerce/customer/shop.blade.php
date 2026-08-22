@extends('backend.layouts.backend')

@section('title', 'Shop')

@section('content')

    <div class="customer-shop-page">

        {{-- ================================================================ --}}
        {{-- SHOP HERO --}}
        {{-- ================================================================ --}}

        <section class="customer-shop-hero">

            <div class="customer-shop-hero__content">

                <div class="customer-shop-hero__eyebrow">

                    <span></span>

                    Ecommerce Store

                </div>

                <h1>
                    Find products
                    <strong>you'll love.</strong>
                </h1>

                <p>
                    Explore our curated collection of quality products,
                    designed to make everyday life better.
                </p>

            </div>


            <div class="customer-shop-hero__stats">

                <div>
                    <strong>24+</strong>
                    <span>Products</span>
                </div>

                <div>
                    <strong>4.8</strong>
                    <span>Average Rating</span>
                </div>

                <div>
                    <strong>30 Day</strong>
                    <span>Easy Returns</span>
                </div>

            </div>

        </section>


        {{-- ================================================================ --}}
        {{-- SHOP TOP BAR --}}
        {{-- ================================================================ --}}

        <div class="customer-shop-topbar">

            <div class="customer-shop-topbar__left">

                <a
                    href="{{ route('customer-shop') }}"
                    class="customer-shop-breadcrumb"
                >
                    Shop
                </a>

                <span>
                /
            </span>

                <strong>
                    All Products
                </strong>

            </div>


            <a
                href="{{ route('cart') }}"
                class="customer-shop-cart"
            >

                <i class="ri-shopping-bag-3-line"></i>

                <span>
                Cart
            </span>

                <b>
                    2
                </b>

            </a>

        </div>


        {{-- ================================================================ --}}
        {{-- SHOP LAYOUT --}}
        {{-- ================================================================ --}}

        <div class="customer-shop-layout">


            {{-- ============================================================ --}}
            {{-- FILTER SIDEBAR --}}
            {{-- ============================================================ --}}

            <aside class="customer-shop-sidebar">


                {{-- Mobile Filter Header --}}
                <div class="customer-shop-sidebar__mobile-header">

                    <strong>
                        Filters
                    </strong>

                    <button
                        type="button"
                        aria-label="Close filters"
                    >
                        <i class="ri-close-line"></i>
                    </button>

                </div>


                {{-- Filter Heading --}}
                <div class="customer-shop-sidebar__heading">

                    <div>

                    <span>
                        Refine
                    </span>

                        <h2>
                            Filters
                        </h2>

                    </div>


                    <button
                        type="button"
                        class="customer-shop-clear-btn"
                    >
                        Clear
                    </button>

                </div>


                {{-- ======================================================== --}}
                {{-- CATEGORY --}}
                {{-- ======================================================== --}}

                <div class="customer-shop-filter">

                    <div class="customer-shop-filter__header">

                        <h3>
                            Categories
                        </h3>

                        <i class="ri-arrow-up-s-line"></i>

                    </div>


                    <div class="customer-shop-filter__body">

                        <label class="customer-shop-check">

                            <input
                                type="checkbox"
                                name="category[]"
                                value="all"
                                checked
                            >

                            <span class="customer-shop-check__box"></span>

                            <span class="customer-shop-check__label">
                            All Products
                        </span>

                            <small>
                                24
                            </small>

                        </label>


                        <label class="customer-shop-check">

                            <input
                                type="checkbox"
                                name="category[]"
                                value="clothing"
                            >

                            <span class="customer-shop-check__box"></span>

                            <span class="customer-shop-check__label">
                            Clothing
                        </span>

                            <small>
                                8
                            </small>

                        </label>


                        <label class="customer-shop-check">

                            <input
                                type="checkbox"
                                name="category[]"
                                value="accessories"
                            >

                            <span class="customer-shop-check__box"></span>

                            <span class="customer-shop-check__label">
                            Accessories
                        </span>

                            <small>
                                6
                            </small>

                        </label>


                        <label class="customer-shop-check">

                            <input
                                type="checkbox"
                                name="category[]"
                                value="electronics"
                            >

                            <span class="customer-shop-check__box"></span>

                            <span class="customer-shop-check__label">
                            Electronics
                        </span>

                            <small>
                                4
                            </small>

                        </label>


                        <label class="customer-shop-check">

                            <input
                                type="checkbox"
                                name="category[]"
                                value="home"
                            >

                            <span class="customer-shop-check__box"></span>

                            <span class="customer-shop-check__label">
                            Home & Living
                        </span>

                            <small>
                                3
                            </small>

                        </label>


                        <label class="customer-shop-check">

                            <input
                                type="checkbox"
                                name="category[]"
                                value="beauty"
                            >

                            <span class="customer-shop-check__box"></span>

                            <span class="customer-shop-check__label">
                            Beauty
                        </span>

                            <small>
                                3
                            </small>

                        </label>

                    </div>

                </div>


                {{-- ======================================================== --}}
                {{-- BRAND --}}
                {{-- ======================================================== --}}

                <div class="customer-shop-filter">

                    <div class="customer-shop-filter__header">

                        <h3>
                            Brands
                        </h3>

                        <i class="ri-arrow-up-s-line"></i>

                    </div>


                    <div class="customer-shop-filter__body">

                        <label class="customer-shop-check">

                            <input
                                type="checkbox"
                                name="brand[]"
                                value="brand-one"
                            >

                            <span class="customer-shop-check__box"></span>

                            <span class="customer-shop-check__label">
                            Brand One
                        </span>

                            <small>
                                8
                            </small>

                        </label>


                        <label class="customer-shop-check">

                            <input
                                type="checkbox"
                                name="brand[]"
                                value="brand-two"
                            >

                            <span class="customer-shop-check__box"></span>

                            <span class="customer-shop-check__label">
                            Brand Two
                        </span>

                            <small>
                                6
                            </small>

                        </label>


                        <label class="customer-shop-check">

                            <input
                                type="checkbox"
                                name="brand[]"
                                value="brand-three"
                            >

                            <span class="customer-shop-check__box"></span>

                            <span class="customer-shop-check__label">
                            Brand Three
                        </span>

                            <small>
                                5
                            </small>

                        </label>


                        <label class="customer-shop-check">

                            <input
                                type="checkbox"
                                name="brand[]"
                                value="brand-four"
                            >

                            <span class="customer-shop-check__box"></span>

                            <span class="customer-shop-check__label">
                            Brand Four
                        </span>

                            <small>
                                5
                            </small>

                        </label>

                    </div>

                </div>


                {{-- ======================================================== --}}
                {{-- PRICE --}}
                {{-- ======================================================== --}}

                <div class="customer-shop-filter">

                    <div class="customer-shop-filter__header">

                        <h3>
                            Price Range
                        </h3>

                        <i class="ri-arrow-up-s-line"></i>

                    </div>


                    <div class="customer-shop-filter__body">

                        <div class="customer-shop-price-inputs">

                            <div>

                                <label for="min_price">
                                    Minimum
                                </label>

                                <div class="customer-shop-price-input">

                                <span>
                                    $
                                </span>

                                    <input
                                        type="number"
                                        id="min_price"
                                        name="min_price"
                                        placeholder="0"
                                    >

                                </div>

                            </div>


                            <div>

                                <label for="max_price">
                                    Maximum
                                </label>

                                <div class="customer-shop-price-input">

                                <span>
                                    $
                                </span>

                                    <input
                                        type="number"
                                        id="max_price"
                                        name="max_price"
                                        placeholder="1000"
                                    >

                                </div>

                            </div>

                        </div>


                        <button
                            type="button"
                            class="customer-shop-filter-btn"
                        >
                            Apply Price
                        </button>

                    </div>

                </div>


                {{-- ======================================================== --}}
                {{-- RATING --}}
                {{-- ======================================================== --}}

                <div class="customer-shop-filter">

                    <div class="customer-shop-filter__header">

                        <h3>
                            Customer Rating
                        </h3>

                        <i class="ri-arrow-up-s-line"></i>

                    </div>


                    <div class="customer-shop-filter__body">

                        <label class="customer-shop-rating-check">

                            <input
                                type="radio"
                                name="rating"
                                value="5"
                            >

                            <span class="customer-shop-radio"></span>

                            <span class="customer-shop-stars">
                            ★★★★★
                        </span>

                            <small>
                                & Up
                            </small>

                        </label>


                        <label class="customer-shop-rating-check">

                            <input
                                type="radio"
                                name="rating"
                                value="4"
                            >

                            <span class="customer-shop-radio"></span>

                            <span class="customer-shop-stars">
                            ★★★★☆
                        </span>

                            <small>
                                & Up
                            </small>

                        </label>


                        <label class="customer-shop-rating-check">

                            <input
                                type="radio"
                                name="rating"
                                value="3"
                            >

                            <span class="customer-shop-radio"></span>

                            <span class="customer-shop-stars">
                            ★★★☆☆
                        </span>

                            <small>
                                & Up
                            </small>

                        </label>

                    </div>

                </div>


                <button
                    type="button"
                    class="customer-shop-sidebar__clear"
                >

                    <i class="ri-refresh-line"></i>

                    Reset all filters

                </button>

            </aside>


            {{-- ============================================================ --}}
            {{-- PRODUCTS --}}
            {{-- ============================================================ --}}

            <main class="customer-shop-products">


                {{-- ======================================================== --}}
                {{-- TOOLBAR --}}
                {{-- ======================================================== --}}

                <div class="customer-shop-toolbar">


                    <div class="customer-shop-toolbar__result">

                        <strong>
                            24
                        </strong>

                        <span>
                        products found
                    </span>

                    </div>


                    <div class="customer-shop-toolbar__right">


                        {{-- Search --}}
                        <div class="customer-shop-search">

                            <i class="ri-search-line"></i>

                            <input
                                type="search"
                                name="search"
                                placeholder="Search products..."
                            >

                        </div>


                        {{-- Sort --}}
                        <div class="customer-shop-sort-wrap">

                        <span>
                            Sort:
                        </span>

                            <select
                                name="sort"
                                class="customer-shop-sort"
                            >

                                <option value="latest">
                                    Latest
                                </option>

                                <option value="price-low">
                                    Price: Low to High
                                </option>

                                <option value="price-high">
                                    Price: High to Low
                                </option>

                                <option value="rating">
                                    Highest Rated
                                </option>

                                <option value="popular">
                                    Most Popular
                                </option>

                            </select>

                        </div>


                        {{-- View --}}
                        <div class="customer-shop-view">

                            <button
                                type="button"
                                class="active"
                                aria-label="Grid view"
                            >
                                <i class="ri-grid-fill"></i>
                            </button>

                            <button
                                type="button"
                                aria-label="List view"
                            >
                                <i class="ri-list-check"></i>
                            </button>

                        </div>

                    </div>

                </div>


                {{-- ======================================================== --}}
                {{-- ACTIVE FILTERS --}}
                {{-- ======================================================== --}}

                <div class="customer-shop-active-filters">

                <span>
                    Active filters:
                </span>

                    <button type="button">

                        Clothing

                        <i class="ri-close-line"></i>

                    </button>

                    <button type="button">

                        In Stock

                        <i class="ri-close-line"></i>

                    </button>

                    <button
                        type="button"
                        class="customer-shop-active-filters__clear"
                    >
                        Clear all
                    </button>

                </div>


                {{-- ======================================================== --}}
                {{-- PRODUCT GRID --}}
                {{-- ======================================================== --}}

                <div class="customer-shop-grid">


                    {{-- ==================================================== --}}
                    {{-- PRODUCT 1 --}}
                    {{-- ==================================================== --}}

                    <article class="customer-product-card">

                        <div class="customer-product-card__image">

                            <a href="{{ route('customer-product-details', ['product' => 1]) }}">

                                <img
                                    src="https://placehold.co/700x780"
                                    alt="Premium Cotton T-Shirt"
                                >

                            </a>


                            <div class="customer-product-card__badges">

                            <span class="sale">
                                Sale
                            </span>

                            </div>


                            <button
                                type="button"
                                class="customer-product-card__wishlist"
                                aria-label="Add to wishlist"
                            >

                                <i class="ri-heart-line"></i>

                            </button>


                            <button
                                type="button"
                                class="customer-product-card__quick"
                            >

                                Quick View

                            </button>

                        </div>


                        <div class="customer-product-card__content">

                        <span class="customer-product-card__category">
                            Clothing
                        </span>


                            <h2>

                                <a href="{{ route('customer-product-details', ['product' => 1]) }}">
                                    Premium Cotton T-Shirt
                                </a>

                            </h2>


                            <div class="customer-product-card__rating">

                            <span>
                                ★★★★★
                            </span>

                                <small>
                                    4.9 (24)
                                </small>

                            </div>


                            <div class="customer-product-card__bottom">

                                <div class="customer-product-card__price">

                                    <del>
                                        $39.99
                                    </del>

                                    <strong>
                                        $29.99
                                    </strong>

                                </div>


                                <button
                                    type="button"
                                    class="customer-product-card__cart"
                                    aria-label="Add to cart"
                                >

                                    <i class="ri-shopping-cart-2-line"></i>

                                </button>

                            </div>

                        </div>

                    </article>


                    {{-- ==================================================== --}}
                    {{-- PRODUCT 2 --}}
                    {{-- ==================================================== --}}

                    <article class="customer-product-card">

                        <div class="customer-product-card__image">

                            <a href="{{ route('customer-product-details', ['product' => 2]) }}">

                                <img
                                    src="https://placehold.co/700x780"
                                    alt="Classic Leather Wallet"
                                >

                            </a>


                            <button
                                type="button"
                                class="customer-product-card__wishlist"
                                aria-label="Add to wishlist"
                            >

                                <i class="ri-heart-line"></i>

                            </button>


                            <button
                                type="button"
                                class="customer-product-card__quick"
                            >

                                Quick View

                            </button>

                        </div>


                        <div class="customer-product-card__content">

                        <span class="customer-product-card__category">
                            Accessories
                        </span>


                            <h2>

                                <a href="{{ route('customer-product-details', ['product' => 2]) }}">
                                    Classic Leather Wallet
                                </a>

                            </h2>


                            <div class="customer-product-card__rating">

                            <span>
                                ★★★★★
                            </span>

                                <small>
                                    4.8 (18)
                                </small>

                            </div>


                            <div class="customer-product-card__bottom">

                                <div class="customer-product-card__price">

                                    <strong>
                                        $49.99
                                    </strong>

                                </div>


                                <button
                                    type="button"
                                    class="customer-product-card__cart"
                                    aria-label="Add to cart"
                                >

                                    <i class="ri-shopping-cart-2-line"></i>

                                </button>

                            </div>

                        </div>

                    </article>


                    {{-- ==================================================== --}}
                    {{-- PRODUCT 3 --}}
                    {{-- ==================================================== --}}

                    <article class="customer-product-card">

                        <div class="customer-product-card__image">

                            <a href="{{ route('customer-product-details', ['product' => 3]) }}">

                                <img
                                    src="https://placehold.co/700x780"
                                    alt="Wireless Headphones"
                                >

                            </a>


                            <div class="customer-product-card__badges">

                            <span class="new">
                                New
                            </span>

                            </div>


                            <button
                                type="button"
                                class="customer-product-card__wishlist"
                                aria-label="Add to wishlist"
                            >

                                <i class="ri-heart-line"></i>

                            </button>


                            <button
                                type="button"
                                class="customer-product-card__quick"
                            >

                                Quick View

                            </button>

                        </div>


                        <div class="customer-product-card__content">

                        <span class="customer-product-card__category">
                            Electronics
                        </span>


                            <h2>

                                <a href="{{ route('customer-product-details', ['product' => 3]) }}">
                                    Wireless Headphones
                                </a>

                            </h2>


                            <div class="customer-product-card__rating">

                            <span>
                                ★★★★☆
                            </span>

                                <small>
                                    4.6 (31)
                                </small>

                            </div>


                            <div class="customer-product-card__bottom">

                                <div class="customer-product-card__price">

                                    <strong>
                                        $79.99
                                    </strong>

                                </div>


                                <button
                                    type="button"
                                    class="customer-product-card__cart"
                                    aria-label="Add to cart"
                                >

                                    <i class="ri-shopping-cart-2-line"></i>

                                </button>

                            </div>

                        </div>

                    </article>


                    {{-- ==================================================== --}}
                    {{-- PRODUCT 4 --}}
                    {{-- ==================================================== --}}

                    <article class="customer-product-card">

                        <div class="customer-product-card__image">

                            <a href="{{ route('customer-product-details', ['product' => 4]) }}">

                                <img
                                    src="https://placehold.co/700x780"
                                    alt="Minimal Ceramic Mug"
                                >

                            </a>


                            <button
                                type="button"
                                class="customer-product-card__wishlist"
                                aria-label="Add to wishlist"
                            >

                                <i class="ri-heart-line"></i>

                            </button>


                            <button
                                type="button"
                                class="customer-product-card__quick"
                            >

                                Quick View

                            </button>

                        </div>


                        <div class="customer-product-card__content">

                        <span class="customer-product-card__category">
                            Home & Living
                        </span>


                            <h2>

                                <a href="{{ route('customer-product-details', ['product' => 4]) }}">
                                    Minimal Ceramic Mug
                                </a>

                            </h2>


                            <div class="customer-product-card__rating">

                            <span>
                                ★★★★★
                            </span>

                                <small>
                                    4.9 (12)
                                </small>

                            </div>


                            <div class="customer-product-card__bottom">

                                <div class="customer-product-card__price">

                                    <strong>
                                        $19.99
                                    </strong>

                                </div>


                                <button
                                    type="button"
                                    class="customer-product-card__cart"
                                    aria-label="Add to cart"
                                >

                                    <i class="ri-shopping-cart-2-line"></i>

                                </button>

                            </div>

                        </div>

                    </article>


                    {{-- ==================================================== --}}
                    {{-- PRODUCT 5 --}}
                    {{-- ==================================================== --}}

                    <article class="customer-product-card">

                        <div class="customer-product-card__image">

                            <a href="{{ route('customer-product-details', ['product' => 5]) }}">

                                <img
                                    src="https://placehold.co/700x780"
                                    alt="Everyday Backpack"
                                >

                            </a>


                            <div class="customer-product-card__badges">

                            <span class="sale">
                                Sale
                            </span>

                            </div>


                            <button
                                type="button"
                                class="customer-product-card__wishlist"
                                aria-label="Add to wishlist"
                            >

                                <i class="ri-heart-line"></i>

                            </button>


                            <button
                                type="button"
                                class="customer-product-card__quick"
                            >

                                Quick View

                            </button>

                        </div>


                        <div class="customer-product-card__content">

                        <span class="customer-product-card__category">
                            Accessories
                        </span>


                            <h2>

                                <a href="{{ route('customer-product-details', ['product' => 5]) }}">
                                    Everyday Backpack
                                </a>

                            </h2>


                            <div class="customer-product-card__rating">

                            <span>
                                ★★★★☆
                            </span>

                                <small>
                                    4.7 (27)
                                </small>

                            </div>


                            <div class="customer-product-card__bottom">

                                <div class="customer-product-card__price">

                                    <del>
                                        $69.99
                                    </del>

                                    <strong>
                                        $54.99
                                    </strong>

                                </div>


                                <button
                                    type="button"
                                    class="customer-product-card__cart"
                                    aria-label="Add to cart"
                                >

                                    <i class="ri-shopping-cart-2-line"></i>

                                </button>

                            </div>

                        </div>

                    </article>


                    {{-- ==================================================== --}}
                    {{-- PRODUCT 6 --}}
                    {{-- ==================================================== --}}

                    <article class="customer-product-card">

                        <div class="customer-product-card__image">

                            <a href="{{ route('customer-product-details', ['product' => 6]) }}">

                                <img
                                    src="https://placehold.co/700x780"
                                    alt="Daily Face Moisturizer"
                                >

                            </a>


                            <button
                                type="button"
                                class="customer-product-card__wishlist"
                                aria-label="Add to wishlist"
                            >

                                <i class="ri-heart-line"></i>

                            </button>


                            <button
                                type="button"
                                class="customer-product-card__quick"
                            >

                                Quick View

                            </button>

                        </div>


                        <div class="customer-product-card__content">

                        <span class="customer-product-card__category">
                            Beauty
                        </span>


                            <h2>

                                <a href="{{ route('customer-product-details', ['product' => 6]) }}">
                                    Daily Face Moisturizer
                                </a>

                            </h2>


                            <div class="customer-product-card__rating">

                            <span>
                                ★★★★★
                            </span>

                                <small>
                                    4.9 (42)
                                </small>

                            </div>


                            <div class="customer-product-card__bottom">

                                <div class="customer-product-card__price">

                                    <strong>
                                        $34.99
                                    </strong>

                                </div>


                                <button
                                    type="button"
                                    class="customer-product-card__cart"
                                    aria-label="Add to cart"
                                >

                                    <i class="ri-shopping-cart-2-line"></i>

                                </button>

                            </div>

                        </div>

                    </article>


                    {{-- ==================================================== --}}
                    {{-- PRODUCT 7 --}}
                    {{-- ==================================================== --}}

                    <article class="customer-product-card">

                        <div class="customer-product-card__image">

                            <a href="{{ route('customer-product-details', ['product' => 7]) }}">

                                <img
                                    src="https://placehold.co/700x780"
                                    alt="Oversized Hoodie"
                                >

                            </a>


                            <div class="customer-product-card__badges">

                            <span class="new">
                                New
                            </span>

                            </div>


                            <button
                                type="button"
                                class="customer-product-card__wishlist"
                                aria-label="Add to wishlist"
                            >

                                <i class="ri-heart-line"></i>

                            </button>


                            <button
                                type="button"
                                class="customer-product-card__quick"
                            >

                                Quick View

                            </button>

                        </div>


                        <div class="customer-product-card__content">

                        <span class="customer-product-card__category">
                            Clothing
                        </span>


                            <h2>

                                <a href="{{ route('customer-product-details', ['product' => 7]) }}">
                                    Oversized Hoodie
                                </a>

                            </h2>


                            <div class="customer-product-card__rating">

                            <span>
                                ★★★★★
                            </span>

                                <small>
                                    4.9 (36)
                                </small>

                            </div>


                            <div class="customer-product-card__bottom">

                                <div class="customer-product-card__price">

                                    <strong>
                                        $64.99
                                    </strong>

                                </div>


                                <button
                                    type="button"
                                    class="customer-product-card__cart"
                                    aria-label="Add to cart"
                                >

                                    <i class="ri-shopping-cart-2-line"></i>

                                </button>

                            </div>

                        </div>

                    </article>


                    {{-- ==================================================== --}}
                    {{-- PRODUCT 8 --}}
                    {{-- ==================================================== --}}

                    <article class="customer-product-card">

                        <div class="customer-product-card__image">

                            <a href="{{ route('customer-product-details', ['product' => 8]) }}">

                                <img
                                    src="https://placehold.co/700x780"
                                    alt="Smart Desk Lamp"
                                >

                            </a>


                            <button
                                type="button"
                                class="customer-product-card__wishlist"
                                aria-label="Add to wishlist"
                            >

                                <i class="ri-heart-line"></i>

                            </button>


                            <button
                                type="button"
                                class="customer-product-card__quick"
                            >

                                Quick View

                            </button>

                        </div>


                        <div class="customer-product-card__content">

                        <span class="customer-product-card__category">
                            Home & Living
                        </span>


                            <h2>

                                <a href="{{ route('customer-product-details', ['product' => 8]) }}">
                                    Smart Desk Lamp
                                </a>

                            </h2>


                            <div class="customer-product-card__rating">

                            <span>
                                ★★★★☆
                            </span>

                                <small>
                                    4.7 (15)
                                </small>

                            </div>


                            <div class="customer-product-card__bottom">

                                <div class="customer-product-card__price">

                                    <strong>
                                        $44.99
                                    </strong>

                                </div>


                                <button
                                    type="button"
                                    class="customer-product-card__cart"
                                    aria-label="Add to cart"
                                >

                                    <i class="ri-shopping-cart-2-line"></i>

                                </button>

                            </div>

                        </div>

                    </article>

                </div>


                {{-- ======================================================== --}}
                {{-- PAGINATION --}}
                {{-- ======================================================== --}}

                <div class="customer-shop-pagination">

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


                    <button type="button">
                        4
                    </button>


                    <span>
                    ...
                </span>


                    <button type="button">
                        8
                    </button>


                    <button
                        type="button"
                        aria-label="Next page"
                    >

                        <i class="ri-arrow-right-s-line"></i>

                    </button>

                </div>

            </main>

        </div>

    </div>

@endsection
