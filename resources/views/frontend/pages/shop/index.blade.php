@extends('frontend.layouts.frontend')

@section('contents')

    <div class="c-hero-section" style="background-image: url({{asset('assets/img/bg/bg-1.jpg')}});">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-6 col-lg-6 col-md-10">
                    <div class="c-hero-content">
                        <ul class="breadcrumb-wrap">
                            <li><a href="{{route('home')}}">Home</a></li>
                            <li><span class="arrow"><i class="ri-arrow-right-line"></i></span></li>
                            <li><span class="current">Marketplace</span></li>
                        </ul>
                        <h1 class="title">
                            Marketplace
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--================================
        Marketplace Categories
    =================================-->
    <section class="marketplace-categories">
        <div class="container">

            <div class="marketplace-section-title">
                <h3>Shop by Categories</h3>

                <a href="#">
                    View All Categories
                    <i class="ri-arrow-right-line"></i>
                </a>
            </div>

            <div class="category-marquee">
                <div class="category-layout">
                    <a href="#" class="category-card">
                        <div class="category-icon">
                            <i class="ri-seedling-line"></i>
                        </div>
                        <span>Agriculture</span>
                    </a>

                    <a href="#" class="category-card">
                        <div class="category-icon">
                            <i class="ri-gemini-line"></i>
                        </div>
                        <span>Minerals &amp; Metals</span>
                    </a>

                    <a href="#" class="category-card">
                        <div class="category-icon">
                            <i class="ri-t-shirt-line"></i>
                        </div>
                        <span>Textiles &amp; Fashion</span>
                    </a>

                    <a href="#" class="category-card">
                        <div class="category-icon">
                            <i class="ri-settings-3-line"></i>
                        </div>
                        <span>Machinery &amp; Equipment</span>
                    </a>

                    <a href="#" class="category-card">
                        <div class="category-icon">
                            <i class="ri-macbook-line"></i>
                        </div>
                        <span>Electronics</span>
                    </a>

                    <a href="#" class="category-card">
                        <div class="category-icon">
                            <i class="ri-car-line"></i>
                        </div>
                        <span>Vehicles</span>
                    </a>

                    <a href="#" class="category-card">
                        <div class="category-icon">
                            <i class="ri-home-4-line"></i>
                        </div>
                        <span>Home &amp; Living</span>
                    </a>

                    <a href="#" class="category-card">
                        <div class="category-icon">
                            <i class="ri-heart-pulse-line"></i>
                        </div>
                        <span>Health &amp; Beauty</span>
                    </a>

                    <a href="#" class="category-card">
                        <div class="category-icon">
                            <i class="ri-apps-line"></i>
                        </div>
                        <span>All Categories</span>
                    </a>
                </div>
                <div class="category-layout">
                    <a href="#" class="category-card">
                        <div class="category-icon">
                            <i class="ri-seedling-line"></i>
                        </div>
                        <span>Agriculture</span>
                    </a>

                    <a href="#" class="category-card">
                        <div class="category-icon">
                            <i class="ri-gemini-line"></i>
                        </div>
                        <span>Minerals &amp; Metals</span>
                    </a>

                    <a href="#" class="category-card">
                        <div class="category-icon">
                            <i class="ri-t-shirt-line"></i>
                        </div>
                        <span>Textiles &amp; Fashion</span>
                    </a>

                    <a href="#" class="category-card">
                        <div class="category-icon">
                            <i class="ri-settings-3-line"></i>
                        </div>
                        <span>Machinery &amp; Equipment</span>
                    </a>

                    <a href="#" class="category-card">
                        <div class="category-icon">
                            <i class="ri-macbook-line"></i>
                        </div>
                        <span>Electronics</span>
                    </a>

                    <a href="#" class="category-card">
                        <div class="category-icon">
                            <i class="ri-car-line"></i>
                        </div>
                        <span>Vehicles</span>
                    </a>

                    <a href="#" class="category-card">
                        <div class="category-icon">
                            <i class="ri-home-4-line"></i>
                        </div>
                        <span>Home &amp; Living</span>
                    </a>

                    <a href="#" class="category-card">
                        <div class="category-icon">
                            <i class="ri-heart-pulse-line"></i>
                        </div>
                        <span>Health &amp; Beauty</span>
                    </a>

                    <a href="#" class="category-card">
                        <div class="category-icon">
                            <i class="ri-apps-line"></i>
                        </div>
                        <span>All Categories</span>
                    </a>
                </div>
            </div>
        </div>
    </section>


    <!--================================
        Marketplace Products
    =================================-->
    <section class="marketplace-products">
        <div class="container">

            <div class="marketplace-products-layout">

                <!-- Filters -->
                <aside class="marketplace-filter">

                    <div class="filter-header">
                        <h4>Filters</h4>

                        <a href="#">Clear All</a>
                    </div>

                    <!-- Category -->
                    <div class="filter-group">
                        <div class="filter-group-title">
                            <span>Category</span>
                            <i class="ri-arrow-up-s-line"></i>
                        </div>

                        <label class="filter-checkbox checked">
                            <input type="checkbox" checked>
                            <span class="checkmark"></span>
                            <span class="label-text">All Categories</span>
                        </label>

                        <label class="filter-checkbox">
                            <input type="checkbox">
                            <span class="checkmark"></span>
                            <span class="label-text">Agriculture</span>
                        </label>

                        <label class="filter-checkbox">
                            <input type="checkbox">
                            <span class="checkmark"></span>
                            <span class="label-text">Minerals &amp; Metals</span>
                        </label>

                        <label class="filter-checkbox">
                            <input type="checkbox">
                            <span class="checkmark"></span>
                            <span class="label-text">Textiles &amp; Fashion</span>
                        </label>

                        <label class="filter-checkbox">
                            <input type="checkbox">
                            <span class="checkmark"></span>
                            <span class="label-text">Machinery &amp; Equipment</span>
                        </label>

                        <label class="filter-checkbox">
                            <input type="checkbox">
                            <span class="checkmark"></span>
                            <span class="label-text">Electronics</span>
                        </label>

                        <label class="filter-checkbox">
                            <input type="checkbox">
                            <span class="checkmark"></span>
                            <span class="label-text">Vehicles</span>
                        </label>

                        <label class="filter-checkbox">
                            <input type="checkbox">
                            <span class="checkmark"></span>
                            <span class="label-text">Home &amp; Living</span>
                        </label>

                        <label class="filter-checkbox">
                            <input type="checkbox">
                            <span class="checkmark"></span>
                            <span class="label-text">Health &amp; Beauty</span>
                        </label>
                    </div>

                    <!-- Price -->
                    <div class="filter-group">
                        <div class="filter-group-title">
                            <span>Price Range</span>
                            <i class="ri-arrow-up-s-line"></i>
                        </div>

                        <div class="price-range">
                            <div class="range-track">
                                <span class="range-progress"></span>
                                <span class="range-dot range-dot-start"></span>
                                <span class="range-dot range-dot-end"></span>
                            </div>

                            <div class="range-values">
                                <span>$0</span>
                                <span>$10,000+</span>
                            </div>
                        </div>
                    </div>

                    <!-- Location -->
                    <div class="filter-group">
                        <div class="filter-group-title">
                            <span>Location</span>
                            <i class="ri-arrow-up-s-line"></i>
                        </div>

                        <label class="filter-checkbox checked">
                            <input type="checkbox" checked>
                            <span class="checkmark"></span>
                            <span class="label-text">All Locations</span>
                        </label>

                        <label class="filter-checkbox">
                            <input type="checkbox">
                            <span class="checkmark"></span>
                            <span class="label-text">Conakry</span>
                        </label>

                        <label class="filter-checkbox">
                            <input type="checkbox">
                            <span class="checkmark"></span>
                            <span class="label-text">Boke</span>
                        </label>

                        <label class="filter-checkbox">
                            <input type="checkbox">
                            <span class="checkmark"></span>
                            <span class="label-text">Kankan</span>
                        </label>

                        <label class="filter-checkbox">
                            <input type="checkbox">
                            <span class="checkmark"></span>
                            <span class="label-text">Nzerekore</span>
                        </label>

                        <label class="filter-checkbox">
                            <input type="checkbox">
                            <span class="checkmark"></span>
                            <span class="label-text">Other Region</span>
                        </label>
                    </div>

                    <!-- Supplier -->
                    <div class="filter-group">
                        <div class="filter-group-title">
                            <span>Supplier Type</span>
                            <i class="ri-arrow-up-s-line"></i>
                        </div>

                        <label class="filter-checkbox checked">
                            <input type="checkbox" checked>
                            <span class="checkmark"></span>
                            <span class="label-text">All Suppliers</span>
                        </label>

                        <label class="filter-checkbox">
                            <input type="checkbox">
                            <span class="checkmark"></span>
                            <span class="label-text">Verified Suppliers</span>
                        </label>

                        <label class="filter-checkbox">
                            <input type="checkbox">
                            <span class="checkmark"></span>
                            <span class="label-text">Premium Suppliers</span>
                        </label>
                    </div>

                    <button type="button" class="apply-filter">
                        Apply Filters
                    </button>

                </aside>


                <!-- Products -->
                <div class="marketplace-product-area">

                    <div class="product-toolbar">
                        <form class="marketplace-search">
                            <div class="search-input">
                                <i class="ri-search-line"></i>
                                <input type="text" placeholder="Search products...">
                            </div>

                            <button type="submit">
                                <i class="ri-search-line"></i>
                            </button>
                        </form>

                        <div class="sort-select">
                            <span>Sort by: <strong>Featured</strong></span>
                            <i class="ri-arrow-down-s-line"></i>
                        </div>

                    </div>


                    <div class="product-grid">

                        <!-- Product 1 -->
                        <div class="product-card">
                            <div class="product-image">

                            <span class="product-badge bestseller">
                                BEST SELLER
                            </span>

                                <button class="wishlist">
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
                                    <a href="#">Raw Cashew Nuts</a>
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


                        <!-- Product 2 -->
                        <div class="product-card">
                            <div class="product-image">

                                <span class="product-badge premium">
                                    PREMIUM
                                </span>

                                <button class="wishlist">
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
                                    <a href="#">Gold Nuggets</a>
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


                        <!-- Product 3 -->
                        <div class="product-card">
                            <div class="product-image">

                                <button class="wishlist">
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
                                    <a href="#">African Wax Print Fabric</a>
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

                        <!-- Product 1 -->
                        <div class="product-card">
                            <div class="product-image">

                            <span class="product-badge bestseller">
                                BEST SELLER
                            </span>

                                <button class="wishlist">
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
                                    <a href="#">Raw Cashew Nuts</a>
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


                        <!-- Product 2 -->
                        <div class="product-card">
                            <div class="product-image">

                                <span class="product-badge premium">
                                    PREMIUM
                                </span>

                                <button class="wishlist">
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
                                    <a href="#">Gold Nuggets</a>
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


                        <!-- Product 3 -->
                        <div class="product-card">
                            <div class="product-image">

                                <button class="wishlist">
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
                                    <a href="#">African Wax Print Fabric</a>
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

                        <!-- Product 1 -->
                        <div class="product-card">
                            <div class="product-image">

                            <span class="product-badge bestseller">
                                BEST SELLER
                            </span>

                                <button class="wishlist">
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
                                    <a href="#">Raw Cashew Nuts</a>
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


                        <!-- Product 2 -->
                        <div class="product-card">
                            <div class="product-image">

                                <span class="product-badge premium">
                                    PREMIUM
                                </span>

                                <button class="wishlist">
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
                                    <a href="#">Gold Nuggets</a>
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


                        <!-- Product 3 -->
                        <div class="product-card">
                            <div class="product-image">

                                <button class="wishlist">
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
                                    <a href="#">African Wax Print Fabric</a>
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

@endsection
