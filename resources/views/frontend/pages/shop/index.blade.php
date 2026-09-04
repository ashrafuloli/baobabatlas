@extends('frontend.layouts.frontend')

@section('contents')

    <div class="marketplace-page">

        {{-- Hero --}}
        <div
            class="c-hero-section"
            style="background-image: url({{ asset('assets/img/bg/bg-1.jpg') }});"
        >
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-6 col-lg-6 col-md-10">
                        <div class="c-hero-content">

                            <ul class="breadcrumb-wrap">
                                <li>
                                    <a href="{{ route('home') }}">
                                        Home
                                    </a>
                                </li>

                                <li>
                                    <span class="arrow">
                                        <i class="ri-arrow-right-line"></i>
                                    </span>
                                </li>

                                <li>
                                    <span class="current">
                                        Marketplace
                                    </span>
                                </li>
                            </ul>

                            <h1 class="title">
                                Marketplace
                            </h1>

                        </div>
                    </div>
                </div>
            </div>
        </div>


        {{-- Shop By Categories --}}
        <section class="marketplace-categories">
            <div class="container">

                <div class="marketplace-section-title">

                    <h3>
                        Shop by Categories
                    </h3>

                    <a href="#">
                        View All Categories

                        <i class="ri-arrow-right-line"></i>
                    </a>

                </div>


                <div class="category-marquee">

                    {{-- First Layout --}}
                    <div class="category-layout">

                        <a href="#" class="category-card">
                            <div class="category-icon">
                                <i class="ri-seedling-line"></i>
                            </div>

                            <span>
                                Agriculture
                            </span>
                        </a>


                        <a href="#" class="category-card">
                            <div class="category-icon">
                                <i class="ri-gemini-line"></i>
                            </div>

                            <span>
                                Minerals &amp; Metals
                            </span>
                        </a>


                        <a href="#" class="category-card">
                            <div class="category-icon">
                                <i class="ri-t-shirt-line"></i>
                            </div>

                            <span>
                                Textiles &amp; Fashion
                            </span>
                        </a>


                        <a href="#" class="category-card">
                            <div class="category-icon">
                                <i class="ri-settings-3-line"></i>
                            </div>

                            <span>
                                Machinery &amp; Equipment
                            </span>
                        </a>


                        <a href="#" class="category-card">
                            <div class="category-icon">
                                <i class="ri-macbook-line"></i>
                            </div>

                            <span>
                                Electronics
                            </span>
                        </a>


                        <a href="#" class="category-card">
                            <div class="category-icon">
                                <i class="ri-car-line"></i>
                            </div>

                            <span>
                                Vehicles
                            </span>
                        </a>


                        <a href="#" class="category-card">
                            <div class="category-icon">
                                <i class="ri-home-4-line"></i>
                            </div>

                            <span>
                                Home &amp; Living
                            </span>
                        </a>


                        <a href="#" class="category-card">
                            <div class="category-icon">
                                <i class="ri-heart-pulse-line"></i>
                            </div>

                            <span>
                                Health &amp; Beauty
                            </span>
                        </a>


                        <a href="#" class="category-card">
                            <div class="category-icon">
                                <i class="ri-apps-line"></i>
                            </div>

                            <span>
                                All Categories
                            </span>
                        </a>

                    </div>


                    {{-- Duplicate Layout --}}
                    <div class="category-layout">

                        <a href="#" class="category-card">
                            <div class="category-icon">
                                <i class="ri-seedling-line"></i>
                            </div>

                            <span>
                                Agriculture
                            </span>
                        </a>


                        <a href="#" class="category-card">
                            <div class="category-icon">
                                <i class="ri-gemini-line"></i>
                            </div>

                            <span>
                                Minerals &amp; Metals
                            </span>
                        </a>


                        <a href="#" class="category-card">
                            <div class="category-icon">
                                <i class="ri-t-shirt-line"></i>
                            </div>

                            <span>
                                Textiles &amp; Fashion
                            </span>
                        </a>


                        <a href="#" class="category-card">
                            <div class="category-icon">
                                <i class="ri-settings-3-line"></i>
                            </div>

                            <span>
                                Machinery &amp; Equipment
                            </span>
                        </a>


                        <a href="#" class="category-card">
                            <div class="category-icon">
                                <i class="ri-macbook-line"></i>
                            </div>

                            <span>
                                Electronics
                            </span>
                        </a>


                        <a href="#" class="category-card">
                            <div class="category-icon">
                                <i class="ri-car-line"></i>
                            </div>

                            <span>
                                Vehicles
                            </span>
                        </a>


                        <a href="#" class="category-card">
                            <div class="category-icon">
                                <i class="ri-home-4-line"></i>
                            </div>

                            <span>
                                Home &amp; Living
                            </span>
                        </a>


                        <a href="#" class="category-card">
                            <div class="category-icon">
                                <i class="ri-heart-pulse-line"></i>
                            </div>

                            <span>
                                Health &amp; Beauty
                            </span>
                        </a>


                        <a href="#" class="category-card">
                            <div class="category-icon">
                                <i class="ri-apps-line"></i>
                            </div>

                            <span>
                                All Categories
                            </span>
                        </a>

                    </div>

                </div>

            </div>
        </section>


        {{-- Products --}}
        <section class="marketplace-products">
            <div class="container">

                <div class="marketplace-products-layout">


                    {{-- Filters --}}
                    <aside class="marketplace-filter">

                        <div class="filter-header">

                            <h4>
                                Filters
                            </h4>

                            <button type="button" class="clear-all">
                                Clear All
                            </button>

                        </div>


                        {{-- Category --}}
                        <div class="filter-group is-open">

                            <button
                                type="button"
                                class="filter-group-title"
                                aria-expanded="true"
                            >
                                <span>
                                    Category
                                </span>

                                <i class="ri-arrow-up-s-line"></i>
                            </button>


                            <div class="filter-group-content">
                                <div class="filter-group-content-inner">

                                    <label class="filter-checkbox">
                                        <input
                                            type="checkbox"
                                            name="category[]"
                                            value="all"
                                            checked
                                        >

                                        <span class="checkmark"></span>

                                        <span class="label-text">
                                            All Categories
                                        </span>
                                    </label>


                                    <label class="filter-checkbox">
                                        <input
                                            type="checkbox"
                                            name="category[]"
                                            value="agriculture"
                                        >

                                        <span class="checkmark"></span>

                                        <span class="label-text">
                                            Agriculture
                                        </span>
                                    </label>


                                    <label class="filter-checkbox">
                                        <input
                                            type="checkbox"
                                            name="category[]"
                                            value="minerals-metals"
                                        >

                                        <span class="checkmark"></span>

                                        <span class="label-text">
                                            Minerals &amp; Metals
                                        </span>
                                    </label>


                                    <label class="filter-checkbox">
                                        <input
                                            type="checkbox"
                                            name="category[]"
                                            value="textiles-fashion"
                                        >

                                        <span class="checkmark"></span>

                                        <span class="label-text">
                                            Textiles &amp; Fashion
                                        </span>
                                    </label>


                                    <label class="filter-checkbox">
                                        <input
                                            type="checkbox"
                                            name="category[]"
                                            value="machinery-equipment"
                                        >

                                        <span class="checkmark"></span>

                                        <span class="label-text">
                                            Machinery &amp; Equipment
                                        </span>
                                    </label>


                                    <label class="filter-checkbox">
                                        <input
                                            type="checkbox"
                                            name="category[]"
                                            value="electronics"
                                        >

                                        <span class="checkmark"></span>

                                        <span class="label-text">
                                            Electronics
                                        </span>
                                    </label>


                                    <label class="filter-checkbox">
                                        <input
                                            type="checkbox"
                                            name="category[]"
                                            value="vehicles"
                                        >

                                        <span class="checkmark"></span>

                                        <span class="label-text">
                                            Vehicles
                                        </span>
                                    </label>


                                    <label class="filter-checkbox">
                                        <input
                                            type="checkbox"
                                            name="category[]"
                                            value="home-living"
                                        >

                                        <span class="checkmark"></span>

                                        <span class="label-text">
                                            Home &amp; Living
                                        </span>
                                    </label>


                                    <label class="filter-checkbox">
                                        <input
                                            type="checkbox"
                                            name="category[]"
                                            value="health-beauty"
                                        >

                                        <span class="checkmark"></span>

                                        <span class="label-text">
                                            Health &amp; Beauty
                                        </span>
                                    </label>

                                </div>
                            </div>

                        </div>


                        {{-- Price Range --}}
                        <div class="filter-group is-open">

                            <button
                                type="button"
                                class="filter-group-title"
                                aria-expanded="true"
                            >
                                <span>
                                    Price Range
                                </span>

                                <i class="ri-arrow-up-s-line"></i>
                            </button>


                            <div class="filter-group-content">
                                <div class="filter-group-content-inner">

                                    <div class="price-range">

                                        <div class="range-slider">

                                            <div class="range-track">
                                                <span class="range-progress"></span>
                                            </div>


                                            <input
                                                type="range"
                                                class="range-input range-input-min"
                                                min="0"
                                                max="10000"
                                                value="0"
                                                step="100"
                                            >


                                            <input
                                                type="range"
                                                class="range-input range-input-max"
                                                min="0"
                                                max="10000"
                                                value="10000"
                                                step="100"
                                            >

                                        </div>


                                        <div class="range-values">

                                            <span class="range-value-min">
                                                $0
                                            </span>

                                            <span class="range-value-max">
                                                $10,000+
                                            </span>

                                        </div>

                                    </div>

                                </div>
                            </div>

                        </div>


                        {{-- Location --}}
                        <div class="filter-group is-open">

                            <button
                                type="button"
                                class="filter-group-title"
                                aria-expanded="true"
                            >
                                <span>
                                    Location
                                </span>

                                <i class="ri-arrow-up-s-line"></i>
                            </button>


                            <div class="filter-group-content">
                                <div class="filter-group-content-inner">

                                    <label class="filter-checkbox">
                                        <input
                                            type="checkbox"
                                            name="location[]"
                                            value="all"
                                            checked
                                        >

                                        <span class="checkmark"></span>

                                        <span class="label-text">
                                            All Locations
                                        </span>
                                    </label>


                                    <label class="filter-checkbox">
                                        <input
                                            type="checkbox"
                                            name="location[]"
                                            value="conakry"
                                        >

                                        <span class="checkmark"></span>

                                        <span class="label-text">
                                            Conakry
                                        </span>
                                    </label>


                                    <label class="filter-checkbox">
                                        <input
                                            type="checkbox"
                                            name="location[]"
                                            value="boke"
                                        >

                                        <span class="checkmark"></span>

                                        <span class="label-text">
                                            Boke
                                        </span>
                                    </label>


                                    <label class="filter-checkbox">
                                        <input
                                            type="checkbox"
                                            name="location[]"
                                            value="kankan"
                                        >

                                        <span class="checkmark"></span>

                                        <span class="label-text">
                                            Kankan
                                        </span>
                                    </label>


                                    <label class="filter-checkbox">
                                        <input
                                            type="checkbox"
                                            name="location[]"
                                            value="nzerekore"
                                        >

                                        <span class="checkmark"></span>

                                        <span class="label-text">
                                            Nzerekore
                                        </span>
                                    </label>


                                    <label class="filter-checkbox">
                                        <input
                                            type="checkbox"
                                            name="location[]"
                                            value="other-region"
                                        >

                                        <span class="checkmark"></span>

                                        <span class="label-text">
                                            Other Region
                                        </span>
                                    </label>

                                </div>
                            </div>

                        </div>


                        {{-- Supplier Type --}}
                        <div class="filter-group is-open">

                            <button
                                type="button"
                                class="filter-group-title"
                                aria-expanded="true"
                            >
                                <span>
                                    Supplier Type
                                </span>

                                <i class="ri-arrow-up-s-line"></i>
                            </button>


                            <div class="filter-group-content">
                                <div class="filter-group-content-inner">

                                    <label class="filter-checkbox">
                                        <input
                                            type="checkbox"
                                            name="supplier[]"
                                            value="all"
                                            checked
                                        >

                                        <span class="checkmark"></span>

                                        <span class="label-text">
                                            All Suppliers
                                        </span>
                                    </label>


                                    <label class="filter-checkbox">
                                        <input
                                            type="checkbox"
                                            name="supplier[]"
                                            value="verified"
                                        >

                                        <span class="checkmark"></span>

                                        <span class="label-text">
                                            Verified Suppliers
                                        </span>
                                    </label>


                                    <label class="filter-checkbox">
                                        <input
                                            type="checkbox"
                                            name="supplier[]"
                                            value="premium"
                                        >

                                        <span class="checkmark"></span>

                                        <span class="label-text">
                                            Premium Suppliers
                                        </span>
                                    </label>

                                </div>
                            </div>

                        </div>


                        <button type="button" class="apply-filter">
                            Apply Filters
                        </button>

                    </aside>


                    {{-- Product Area --}}
                    <div class="marketplace-product-area">

                        <div class="product-toolbar">


                            {{-- Search --}}
                            <form class="marketplace-search">

                                <div class="search-input">

                                    <i class="ri-search-line"></i>

                                    <input
                                        type="text"
                                        name="search"
                                        placeholder="Search products..."
                                    >

                                </div>


                                <button type="submit">
                                    <i class="ri-search-line"></i>
                                </button>

                            </form>


                            {{-- Sort --}}
                            <div class="sort-select">
                                <button
                                    type="button"
                                    class="sort-select-trigger"
                                    aria-expanded="false"
                                >
        <span class="sort-select-value">
            <span class="sort-label">Sort by:</span>
            <strong>Featured</strong>
        </span>

                                    <i class="ri-arrow-down-s-line"></i>
                                </button>

                                <div class="sort-select-options">

                                    <button
                                        type="button"
                                        class="sort-option is-selected"
                                        data-value="featured"
                                    >
                                        Featured
                                    </button>

                                    <button
                                        type="button"
                                        class="sort-option"
                                        data-value="newest"
                                    >
                                        Newest Arrivals
                                    </button>

                                    <button
                                        type="button"
                                        class="sort-option"
                                        data-value="best-selling"
                                    >
                                        Best Selling
                                    </button>

                                    <button
                                        type="button"
                                        class="sort-option"
                                        data-value="price-low-high"
                                    >
                                        Price: Low to High
                                    </button>

                                    <button
                                        type="button"
                                        class="sort-option"
                                        data-value="price-high-low"
                                    >
                                        Price: High to Low
                                    </button>

                                    <button
                                        type="button"
                                        class="sort-option"
                                        data-value="top-rated"
                                    >
                                        Top Rated
                                    </button>

                                </div>

                                <input
                                    type="hidden"
                                    name="sort"
                                    value="featured"
                                    class="sort-input"
                                >
                            </div>

                        </div>


                        {{-- Product Grid --}}
                        <div class="product-grid">


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

                        </div>

                    </div>

                </div>

            </div>
        </section>

        <!--================================
            Why Buy
        =================================-->
        <section class="marketplace-benefits">
            <div class="container">

                <div class="benefits-heading">
                    <h2>Why Buy on Baobab Atlas Marketplace?</h2>
                </div>

                <div class="benefits-grid">

                    <div class="benefit-card">
                        <div class="benefit-icon">
                            <i class="ri-shield-check-line"></i>
                        </div>

                        <div>
                            <h4>Verified Suppliers</h4>
                            <p>
                                All suppliers are carefully verified for your peace of mind.
                            </p>
                        </div>
                    </div>

                    <div class="benefit-card">
                        <div class="benefit-icon">
                            <i class="ri-bank-card-line"></i>
                        </div>

                        <div>
                            <h4>Secure Payments</h4>
                            <p>
                                Your payments are protected with secure and trusted methods.
                            </p>
                        </div>
                    </div>

                    <div class="benefit-card">
                        <div class="benefit-icon">
                            <i class="ri-award-line"></i>
                        </div>

                        <div>
                            <h4>Quality Assurance</h4>
                            <p>
                                Quality products that meet international standards.
                            </p>
                        </div>
                    </div>

                    <div class="benefit-card">
                        <div class="benefit-icon">
                            <i class="ri-global-line"></i>
                        </div>

                        <div>
                            <h4>Global Shipping</h4>
                            <p>
                                Fast and reliable delivery to anywhere in the world.
                            </p>
                        </div>
                    </div>

                    <div class="benefit-card">
                        <div class="benefit-icon">
                            <i class="ri-arrow-go-back-line"></i>
                        </div>

                        <div>
                            <h4>Easy Returns</h4>
                            <p>
                                Hassle-free returns and dedicated customer support.
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </section>

    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const marketplacePage =
                document.querySelector('.marketplace-page');

            if (!marketplacePage) {
                return;
            }


            /*
            =====================================
                Filter Accordion
            =====================================
            */
            const filterGroups =
                marketplacePage.querySelectorAll('.filter-group');


            filterGroups.forEach(function (filterGroup) {

                const title =
                    filterGroup.querySelector('.filter-group-title');


                if (!title) {
                    return;
                }


                title.addEventListener('click', function () {

                    const isOpen =
                        filterGroup.classList.contains('is-open');


                    filterGroup.classList.toggle(
                        'is-open',
                        !isOpen
                    );


                    title.setAttribute(
                        'aria-expanded',
                        !isOpen ? 'true' : 'false'
                    );

                });

            });


            /*
            =====================================
                Price Range
            =====================================
            */
            const priceRange =
                marketplacePage.querySelector('.price-range');


            if (priceRange) {

                const minInput =
                    priceRange.querySelector('.range-input-min');

                const maxInput =
                    priceRange.querySelector('.range-input-max');

                const progress =
                    priceRange.querySelector('.range-progress');

                const minValue =
                    priceRange.querySelector('.range-value-min');

                const maxValue =
                    priceRange.querySelector('.range-value-max');


                const minimumGap = 100;


                const formatPrice = function (value) {

                    return '$' +
                        Number(value).toLocaleString();

                };


                const updatePriceRange = function () {

                    let min =
                        parseInt(minInput.value, 10);

                    let max =
                        parseInt(maxInput.value, 10);


                    if (max - min < minimumGap) {

                        if (
                            document.activeElement === minInput
                        ) {

                            min = max - minimumGap;

                            minInput.value = min;

                        } else {

                            max = min + minimumGap;

                            maxInput.value = max;

                        }

                    }


                    const rangeMin =
                        parseInt(minInput.min, 10);

                    const rangeMax =
                        parseInt(minInput.max, 10);


                    const minPercent =
                        ((min - rangeMin) /
                            (rangeMax - rangeMin)) * 100;


                    const maxPercent =
                        ((max - rangeMin) /
                            (rangeMax - rangeMin)) * 100;


                    progress.style.left =
                        minPercent + '%';


                    progress.style.right =
                        (100 - maxPercent) + '%';


                    minValue.textContent =
                        formatPrice(min);


                    if (max === rangeMax) {

                        maxValue.textContent =
                            formatPrice(max) + '+';

                    } else {

                        maxValue.textContent =
                            formatPrice(max);

                    }


                    if (min > rangeMin) {

                        minInput.style.zIndex = '4';

                    } else {

                        minInput.style.zIndex = '2';

                    }


                    maxInput.style.zIndex = '3';

                };


                minInput.addEventListener(
                    'input',
                    updatePriceRange
                );


                maxInput.addEventListener(
                    'input',
                    updatePriceRange
                );


                minInput.addEventListener(
                    'change',
                    updatePriceRange
                );


                maxInput.addEventListener(
                    'change',
                    updatePriceRange
                );


                updatePriceRange();

            }


            /*
            =====================================
                Custom Sort Dropdown
            =====================================
            */
            const sortSelect =
                marketplacePage.querySelector('.sort-select');


            if (sortSelect) {

                const sortTrigger =
                    sortSelect.querySelector(
                        '.sort-select-trigger'
                    );


                const sortOptions =
                    sortSelect.querySelectorAll(
                        '.sort-option'
                    );


                const sortValue =
                    sortSelect.querySelector(
                        '.sort-select-value strong'
                    );


                const sortInput =
                    sortSelect.querySelector(
                        '.sort-input'
                    );


                if (sortTrigger) {

                    sortTrigger.addEventListener(
                        'click',
                        function () {

                            const isOpen =
                                sortSelect.classList.contains(
                                    'is-open'
                                );


                            sortSelect.classList.toggle(
                                'is-open',
                                !isOpen
                            );


                            sortTrigger.setAttribute(
                                'aria-expanded',
                                !isOpen
                                    ? 'true'
                                    : 'false'
                            );

                        }
                    );

                }


                sortOptions.forEach(
                    function (option) {

                        option.addEventListener(
                            'click',
                            function () {

                                const value =
                                    option.dataset.value;


                                const text =
                                    option.textContent.trim();


                                if (sortValue) {

                                    sortValue.textContent =
                                        text;

                                }


                                if (sortInput) {

                                    sortInput.value =
                                        value;

                                }


                                sortOptions.forEach(
                                    function (item) {

                                        item.classList.remove(
                                            'is-selected'
                                        );

                                    }
                                );


                                option.classList.add(
                                    'is-selected'
                                );


                                sortSelect.classList.remove(
                                    'is-open'
                                );


                                if (sortTrigger) {

                                    sortTrigger.setAttribute(
                                        'aria-expanded',
                                        'false'
                                    );

                                }

                            }
                        );

                    }
                );


                document.addEventListener(
                    'click',
                    function (event) {

                        if (
                            !sortSelect.contains(
                                event.target
                            )
                        ) {

                            sortSelect.classList.remove(
                                'is-open'
                            );


                            if (sortTrigger) {

                                sortTrigger.setAttribute(
                                    'aria-expanded',
                                    'false'
                                );

                            }

                        }

                    }
                );

            }


            /*
            =====================================
                Clear All
            =====================================
            */
            const clearAll =
                marketplacePage.querySelector('.clear-all');


            if (clearAll) {

                clearAll.addEventListener(
                    'click',
                    function () {

                        const checkboxes =
                            marketplacePage.querySelectorAll(
                                '.filter-checkbox input[type="checkbox"]'
                            );


                        checkboxes.forEach(
                            function (checkbox) {

                                checkbox.checked = false;

                            }
                        );


                        marketplacePage
                            .querySelectorAll(
                                'input[value="all"]'
                            )
                            .forEach(
                                function (checkbox) {

                                    checkbox.checked = true;

                                }
                            );


                        if (priceRange) {

                            minInput.value =
                                minInput.min;


                            maxInput.value =
                                maxInput.max;


                            updatePriceRange();

                        }

                    }
                );

            }

        });
    </script>

@endsection
