@extends('frontend.layouts.frontend')

@section('contents')

    <div class="marketplace-page">

        {{-- =========================================
            Hero
        ========================================== --}}
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


        {{-- =========================================
            Shop By Categories
        ========================================== --}}
        <section class="marketplace-categories">

            <div class="container">

                <div class="marketplace-section-title">

                    <h3>
                        Shop by Categories
                    </h3>

                    <a href="{{ route('shop') }}">
                        View All Categories

                        <i class="ri-arrow-right-line"></i>
                    </a>

                </div>

                <div class="category-marquee">

                    {{-- =========================================
                        First Marquee
                    ========================================== --}}
                    <div class="category-layout">

                        {{-- All Categories --}}
                        <a
                            href="{{ route('shop') }}"
                            class="category-card"
                        >

                            <div class="category-icon">
                                <i class="ri-apps-line"></i>
                            </div>

                            <span>
                        All Categories
                    </span>

                        </a>


                        @foreach ($categories as $category)

                            @php
                                $categoryIcon = match ($category->slug) {
                                    'electronics' => 'ri-macbook-line',
                                    'fashion' => 'ri-t-shirt-line',
                                    'home-living' => 'ri-home-4-line',
                                    'computers' => 'ri-computer-line',
                                    default => 'ri-apps-line',
                                };

                                $categoryImage = $category->image ?? null;

                                $categoryImageUrl = $categoryImage
                                    ? (
                                        filter_var(
                                            $categoryImage,
                                            FILTER_VALIDATE_URL
                                        )
                                            ? $categoryImage
                                            : asset($categoryImage)
                                    )
                                    : null;
                            @endphp

                            {{-- =========================================
                                Parent Category
                            ========================================== --}}
                            <a
                                href="{{ route('shop', [
                            'category[]' => $category->slug,
                        ]) }}"
                                class="category-card"
                            >

                                <div class="category-icon">

                                    @if ($categoryImageUrl)

                                        <img
                                            src="{{ $categoryImageUrl }}"
                                            alt="{{ $category->name }}"
                                            loading="lazy"
                                        >

                                    @else

                                        <i class="{{ $categoryIcon }}"></i>

                                    @endif

                                </div>

                                <span>
                            {{ $category->name }}
                        </span>

                            </a>


                            {{-- =========================================
                                Child Categories
                            ========================================== --}}
                            @foreach ($category->children as $child)

                                @php
                                    $childIcon = match ($child->slug) {
                                        'smartphones' => 'ri-smartphone-line',
                                        'laptops' => 'ri-macbook-line',
                                        'audio' => 'ri-headphone-line',
                                        'accessories' => 'ri-usb-line',
                                        'mens-clothing' => 'ri-shirt-line',
                                        'womens-clothing' => 'ri-shirt-line',
                                        'shoes' => 'ri-footprint-line',
                                        'sportswear' => 'ri-run-line',
                                        'kitchen' => 'ri-restaurant-line',
                                        'home-accessories' => 'ri-home-gear-line',
                                        'lighting' => 'ri-lightbulb-line',
                                        'keyboards' => 'ri-keyboard-line',
                                        'mice' => 'ri-mouse-line',
                                        'webcams' => 'ri-camera-line',
                                        'computer-accessories' => 'ri-tools-line',
                                        default => 'ri-apps-line',
                                    };

                                    $childImage = $child->image ?? null;

                                    $childImageUrl = $childImage
                                        ? (
                                            filter_var(
                                                $childImage,
                                                FILTER_VALIDATE_URL
                                            )
                                                ? $childImage
                                                : asset($childImage)
                                        )
                                        : null;
                                @endphp

                                <a
                                    href="{{ route('shop', [
                                'category[]' => $child->slug,
                            ]) }}"
                                    class="category-card"
                                >

                                    <div class="category-icon">

                                        @if ($childImageUrl)

                                            <img
                                                src="{{ $childImageUrl }}"
                                                alt="{{ $child->name }}"
                                                loading="lazy"
                                            >

                                        @else

                                            <i class="{{ $childIcon }}"></i>

                                        @endif

                                    </div>

                                    <span>
                                {{ $child->name }}
                            </span>

                                </a>

                            @endforeach

                        @endforeach

                    </div>


                    {{-- =========================================
                        Second Marquee
                    ========================================== --}}
                    <div class="category-layout">

                        {{-- All Categories --}}
                        <a
                            href="{{ route('shop') }}"
                            class="category-card"
                        >

                            <div class="category-icon">
                                <i class="ri-apps-line"></i>
                            </div>

                            <span>
                        All Categories
                    </span>

                        </a>


                        @foreach ($categories as $category)

                            @php
                                $categoryIcon = match ($category->slug) {
                                    'electronics' => 'ri-macbook-line',
                                    'fashion' => 'ri-t-shirt-line',
                                    'home-living' => 'ri-home-4-line',
                                    'computers' => 'ri-computer-line',
                                    default => 'ri-apps-line',
                                };

                                $categoryImage = $category->image ?? null;

                                $categoryImageUrl = $categoryImage
                                    ? (
                                        filter_var(
                                            $categoryImage,
                                            FILTER_VALIDATE_URL
                                        )
                                            ? $categoryImage
                                            : asset($categoryImage)
                                    )
                                    : null;
                            @endphp

                            {{-- Parent Category --}}
                            <a
                                href="{{ route('shop', [
                            'category[]' => $category->slug,
                        ]) }}"
                                class="category-card"
                            >

                                <div class="category-icon">

                                    @if ($categoryImageUrl)

                                        <img
                                            src="{{ $categoryImageUrl }}"
                                            alt="{{ $category->name }}"
                                            loading="lazy"
                                        >

                                    @else

                                        <i class="{{ $categoryIcon }}"></i>

                                    @endif

                                </div>

                                <span>
                            {{ $category->name }}
                        </span>

                            </a>


                            {{-- Child Categories --}}
                            @foreach ($category->children as $child)

                                @php
                                    $childIcon = match ($child->slug) {
                                        'smartphones' => 'ri-smartphone-line',
                                        'laptops' => 'ri-macbook-line',
                                        'audio' => 'ri-headphone-line',
                                        'accessories' => 'ri-usb-line',
                                        'mens-clothing' => 'ri-shirt-line',
                                        'womens-clothing' => 'ri-shirt-line',
                                        'shoes' => 'ri-footprint-line',
                                        'sportswear' => 'ri-run-line',
                                        'kitchen' => 'ri-restaurant-line',
                                        'home-accessories' => 'ri-home-gear-line',
                                        'lighting' => 'ri-lightbulb-line',
                                        'keyboards' => 'ri-keyboard-line',
                                        'mice' => 'ri-mouse-line',
                                        'webcams' => 'ri-camera-line',
                                        'computer-accessories' => 'ri-tools-line',
                                        default => 'ri-apps-line',
                                    };

                                    $childImage = $child->image ?? null;

                                    $childImageUrl = $childImage
                                        ? (
                                            filter_var(
                                                $childImage,
                                                FILTER_VALIDATE_URL
                                            )
                                                ? $childImage
                                                : asset($childImage)
                                        )
                                        : null;
                                @endphp

                                <a
                                    href="{{ route('shop', [
                                'category[]' => $child->slug,
                            ]) }}"
                                    class="category-card"
                                >

                                    <div class="category-icon">

                                        @if ($childImageUrl)

                                            <img
                                                src="{{ $childImageUrl }}"
                                                alt="{{ $child->name }}"
                                                loading="lazy"
                                            >

                                        @else

                                            <i class="{{ $childIcon }}"></i>

                                        @endif

                                    </div>

                                    <span>
                                {{ $child->name }}
                            </span>

                                </a>

                            @endforeach

                        @endforeach

                    </div>

                </div>

            </div>

        </section>

        {{-- =========================================
            Products
        ========================================== --}}
        <section class="marketplace-products">

            <div class="container">

                <form
                    class="marketplace-products-form"
                    method="GET"
                    action="{{ route('shop') }}"
                >

                    <div class="marketplace-products-layout">


                        {{-- =====================================
                            Sidebar Filters
                        ====================================== --}}
                        <aside class="marketplace-filter">

                            <div class="filter-header">

                                <h4>
                                    Filters
                                </h4>

                                <a
                                    href="{{ route('shop') }}"
                                    class="clear-all"
                                >
                                    Clear All
                                </a>

                            </div>


                            {{-- =================================
                                Category Filter
                            ================================== --}}
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


                                        {{-- All Categories --}}
                                        <label class="filter-checkbox">

                                            <input
                                                type="radio"
                                                name="category"
                                                value=""
                                                @checked(!request()->filled('category'))
                                            >

                                            <span class="checkmark"></span>

                                            <span class="label-text">
                                                All Categories
                                            </span>

                                        </label>


                                        {{-- Main Categories --}}
                                        @foreach ($categories as $category)

                                            @php
                                                $children = $category->children ?? collect();

                                                $hasSelectedChild = $children->contains(
                                                    fn ($child) =>
                                                        request('category') === $child->slug
                                                );

                                                $categoryIsSelected =
                                                    request('category') === $category->slug ||
                                                    $hasSelectedChild;
                                            @endphp


                                            <div
                                                class="category-filter-item {{ $categoryIsSelected ? 'is-selected' : '' }}"
                                            >

                                                <div class="category-filter-heading">

                                                    <label class="filter-checkbox">

                                                        <input
                                                            type="radio"
                                                            name="category"
                                                            value="{{ $category->slug }}"
                                                            @checked(request('category') === $category->slug)
                                                        >

                                                        <span class="checkmark"></span>

                                                        <span class="label-text">
                                                            {{ $category->name }}
                                                        </span>

                                                    </label>


                                                    @if ($children->isNotEmpty())

                                                        <button
                                                            type="button"
                                                            class="subcategory-toggle"
                                                            aria-expanded="{{ $categoryIsSelected ? 'true' : 'false' }}"
                                                        >

                                                            <i class="ri-arrow-down-s-line"></i>

                                                        </button>

                                                    @endif

                                                </div>


                                                @if ($children->isNotEmpty())

                                                    <div
                                                        class="subcategory-list"
                                                        style="{{ $categoryIsSelected ? 'display: block;' : '' }}"
                                                    >

                                                        @foreach ($children as $subcategory)

                                                            <label class="filter-checkbox filter-checkbox-subcategory">

                                                                <input
                                                                    type="radio"
                                                                    name="category"
                                                                    value="{{ $subcategory->slug }}"
                                                                    @checked(request('category') === $subcategory->slug)
                                                                >

                                                                <span class="checkmark"></span>

                                                                <span class="label-text">
                                                                    {{ $subcategory->name }}
                                                                </span>

                                                            </label>

                                                        @endforeach

                                                    </div>

                                                @endif

                                            </div>

                                        @endforeach

                                    </div>

                                </div>

                            </div>


                            {{-- =================================
                                Price Range
                            ================================== --}}
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
                                                    max="{{ $priceMax }}"
                                                    value="{{ request('min_price', 0) }}"
                                                    step="1"
                                                >


                                                <input
                                                    type="range"
                                                    class="range-input range-input-max"
                                                    min="0"
                                                    max="{{ $priceMax }}"
                                                    value="{{ request('max_price', $priceMax) }}"
                                                    step="1"
                                                >

                                            </div>


                                            <div class="range-values">

                                                <span class="range-value-min">
                                                    ${{ number_format((float) request('min_price', 0), 0) }}
                                                </span>

                                                <span class="range-value-max">
                                                    ${{ number_format((float) request('max_price', $priceMax), 0) }}{{ request('max_price', $priceMax) >= $priceMax ? '+' : '' }}
                                                </span>

                                            </div>


                                            <input
                                                type="hidden"
                                                name="min_price"
                                                class="min-price-input"
                                                value="{{ request('min_price', 0) }}"
                                            >


                                            <input
                                                type="hidden"
                                                name="max_price"
                                                class="max-price-input"
                                                value="{{ request('max_price', $priceMax) }}"
                                            >

                                        </div>

                                    </div>

                                </div>

                            </div>


                            {{-- =================================
                                Brands
                            ================================== --}}
                            <div class="filter-group is-open">

                                <button
                                    type="button"
                                    class="filter-group-title"
                                    aria-expanded="true"
                                >

                                    <span>
                                        Brands
                                    </span>

                                    <i class="ri-arrow-up-s-line"></i>

                                </button>


                                <div class="filter-group-content">

                                    <div class="filter-group-content-inner">


                                        {{-- All Brands --}}
                                        <label class="filter-checkbox">

                                            <input
                                                type="radio"
                                                name="brand"
                                                value=""
                                                @checked(!request()->filled('brand'))
                                            >

                                            <span class="checkmark"></span>

                                            <span class="label-text">
                                                All Brands
                                            </span>

                                        </label>


                                        @foreach ($brands as $brand)

                                            <label class="filter-checkbox">

                                                <input
                                                    type="radio"
                                                    name="brand"
                                                    value="{{ $brand->slug }}"
                                                    @checked(request('brand') === $brand->slug)
                                                >

                                                <span class="checkmark"></span>

                                                <span class="label-text">
                                                    {{ $brand->name }}
                                                </span>

                                            </label>

                                        @endforeach

                                    </div>

                                </div>

                            </div>


                            {{-- =================================
                                Attributes
                            ================================== --}}
                            @foreach ($attributes as $attribute)

                                @php
                                    $selectedAttributeValues = collect(
                                        (array) request("attribute.{$attribute->slug}", [])
                                    );
                                @endphp

                                <div class="filter-group is-open">

                                    <button
                                        type="button"
                                        class="filter-group-title"
                                        aria-expanded="true"
                                    >

                                        <span>
                                            {{ $attribute->name }}
                                        </span>

                                        <i class="ri-arrow-up-s-line"></i>

                                    </button>


                                    <div class="filter-group-content">

                                        <div class="filter-group-content-inner">

                                            @foreach ($attribute->values as $value)

                                                <label class="filter-checkbox">

                                                    <input
                                                        type="checkbox"
                                                        name="attribute[{{ $attribute->slug }}][]"
                                                        value="{{ $value->slug }}"
                                                        @checked(
                                                            $selectedAttributeValues->contains($value->slug)
                                                        )
                                                    >

                                                    <span class="checkmark"></span>

                                                    <span class="label-text">
                                                        {{ $value->label }}
                                                    </span>

                                                </label>

                                            @endforeach

                                        </div>

                                    </div>

                                </div>

                            @endforeach


                            <button
                                type="submit"
                                class="apply-filter"
                            >
                                Apply Filters
                            </button>

                        </aside>


                        {{-- =====================================
                            Product Area
                        ====================================== --}}
                        <div class="marketplace-product-area">


                            {{-- Toolbar --}}
                            <div class="product-toolbar">


                                {{-- Search --}}
                                <div class="marketplace-search">

                                    <div class="search-input">

                                        <i class="ri-search-line"></i>

                                        <input
                                            type="search"
                                            name="search"
                                            value="{{ request('search') }}"
                                            placeholder="Search products..."
                                        >

                                    </div>


                                    <button type="submit">

                                        <i class="ri-search-line"></i>

                                    </button>

                                </div>


                                {{-- Sort --}}
                                <div class="sort-select">

                                    @php
                                        $currentSort = request('sort', 'featured');

                                        $sortLabel = match ($currentSort) {
                                            'newest' => 'Newest Arrivals',
                                            'price-low-high' => 'Price: Low to High',
                                            'price-high-low' => 'Price: High to Low',
                                            default => 'Featured',
                                        };
                                    @endphp


                                    <button
                                        type="button"
                                        class="sort-select-trigger"
                                        aria-expanded="false"
                                    >

                                        <span class="sort-select-value">

                                            <span class="sort-label">
                                                Sort by:
                                            </span>

                                            <strong>
                                                {{ $sortLabel }}
                                            </strong>

                                        </span>


                                        <i class="ri-arrow-down-s-line"></i>

                                    </button>


                                    <div class="sort-select-options">

                                        <button
                                            type="button"
                                            class="sort-option {{ $currentSort === 'featured' ? 'is-selected' : '' }}"
                                            data-value="featured"
                                        >
                                            Featured
                                        </button>


                                        <button
                                            type="button"
                                            class="sort-option {{ $currentSort === 'newest' ? 'is-selected' : '' }}"
                                            data-value="newest"
                                        >
                                            Newest Arrivals
                                        </button>


                                        <button
                                            type="button"
                                            class="sort-option {{ $currentSort === 'price-low-high' ? 'is-selected' : '' }}"
                                            data-value="price-low-high"
                                        >
                                            Price: Low to High
                                        </button>


                                        <button
                                            type="button"
                                            class="sort-option {{ $currentSort === 'price-high-low' ? 'is-selected' : '' }}"
                                            data-value="price-high-low"
                                        >
                                            Price: High to Low
                                        </button>

                                    </div>


                                    <input
                                        type="hidden"
                                        name="sort"
                                        value="{{ $currentSort }}"
                                        class="sort-input"
                                    >

                                </div>

                            </div>


                            {{-- Product Result Summary --}}
                            <div class="filter-summary">

                                <div class="result-count">

                                    Showing
                                    <strong>
                                        {{ $products->firstItem() ?? 0 }}
                                    </strong>
                                    to
                                    <strong>
                                        {{ $products->lastItem() ?? 0 }}
                                    </strong>
                                    of
                                    <strong>
                                        {{ $products->total() }}
                                    </strong>
                                    products

                                </div>


                                @if (
                                    request()->filled('search') ||
                                    request()->filled('category') ||
                                    request()->filled('brand') ||
                                    request()->filled('min_price') ||
                                    request()->filled('max_price') ||
                                    request()->filled('sort')
                                )

                                    <div class="active-filters">

                                        <a
                                            href="{{ route('shop') }}"
                                            class="active-filter"
                                        >

                                            Clear Filters

                                            <i class="ri-close-line"></i>

                                        </a>

                                    </div>

                                @endif

                            </div>


                            {{-- =================================
                                Product Grid
                            ================================== --}}
                            <div class="product-grid">

                                @forelse ($products as $product)

                                    @php
                                        $thumbnail = $product->thumbnail;

                                        $imageUrl = $thumbnail
                                            ? (
                                                filter_var(
                                                    $thumbnail,
                                                    FILTER_VALIDATE_URL
                                                )
                                                    ? $thumbnail
                                                    : asset($thumbnail)
                                            )
                                            : asset(
                                                'assets/img/products/product-placeholder.jpg'
                                            );

                                        $stock = $product->variants->sum('stock');
                                    @endphp


                                    <div class="product-card">

                                        <div class="product-image">


                                            {{-- Source Badge --}}
                                            @if ($product->source !== 'own')

                                                <span class="product-badge premium">
                                                    {{ strtoupper($product->source) }}
                                                </span>

                                            @endif


                                            {{-- Out Of Stock --}}
                                            @if ($stock <= 0)

                                                <span class="product-badge out-of-stock">
                                                    OUT OF STOCK
                                                </span>

                                            @endif


                                            {{-- Wishlist --}}
                                            <button
                                                type="button"
                                                class="wishlist"
                                                data-product-id="{{ $product->id }}"
                                                aria-label="Add {{ $product->name }} to wishlist"
                                            >

                                                <i class="ri-heart-line"></i>

                                            </button>


                                            {{-- Product Image --}}
                                            <a
                                                href="{{ route('shop.details', $product->slug) }}"
                                            >

                                                <img
                                                    src="{{ $imageUrl }}"
                                                    alt="{{ $product->name }}"
                                                    loading="lazy"
                                                >

                                            </a>

                                        </div>


                                        <div class="product-content">

                                            {{-- Brand --}}
                                            @if ($product->brand)

                                                <span class="product-brand">
                                                    {{ $product->brand->name }}
                                                </span>

                                            @endif


                                            {{-- Product Name --}}
                                            <h4>

                                                <a
                                                    href="{{ route('shop.details', $product->slug) }}"
                                                >
                                                    {{ $product->name }}
                                                </a>

                                            </h4>


                                            {{-- Price --}}
                                            <strong class="product-price">

                                                ${{ number_format(
                                                    (float) $product->price,
                                                    2
                                                ) }}

                                            </strong>


                                            {{-- Category --}}
                                            @if ($product->categories->isNotEmpty())

                                                <span class="product-category">

                                                    {{ $product->categories->first()->name }}

                                                </span>

                                            @endif

                                        </div>

                                    </div>

                                @empty

                                    <div class="marketplace-empty">

                                        <div class="marketplace-empty-icon">

                                            <i class="ri-shopping-bag-3-line"></i>

                                        </div>


                                        <h4>
                                            No Products Found
                                        </h4>


                                        <p>
                                            We couldn't find any products matching your current filters.
                                        </p>


                                        <a
                                            href="{{ route('shop') }}"
                                            class="apply-filter"
                                        >
                                            Clear Filters
                                        </a>

                                    </div>

                                @endforelse

                            </div>


                            {{-- =================================
                                Pagination
                            ================================== --}}
                            @if ($products->hasPages())

                                <div class="marketplace-pagination">

                                    {{ $products->links('frontend.components.pagination') }}

                                </div>

                            @endif

                        </div>

                    </div>

                </form>

            </div>

        </section>


        {{-- =========================================
            Benefits
        ========================================== --}}
        <section class="marketplace-benefits">

            <div class="container">

                <div class="benefits-heading">

                    <h2>
                        Why Buy on Baobab Atlas Marketplace?
                    </h2>

                </div>


                <div class="benefits-grid">

                    <div class="benefit-card">

                        <div class="benefit-icon">
                            <i class="ri-shield-check-line"></i>
                        </div>

                        <div>

                            <h4>
                                Verified Suppliers
                            </h4>

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

                            <h4>
                                Secure Payments
                            </h4>

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

                            <h4>
                                Quality Assurance
                            </h4>

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

                            <h4>
                                Global Shipping
                            </h4>

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

                            <h4>
                                Easy Returns
                            </h4>

                            <p>
                                Hassle-free returns and dedicated customer support.
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </section>

    </div>

@endsection


@push('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const marketplacePage =
                document.querySelector('.marketplace-page');

            if (!marketplacePage) {
                return;
            }


            const productsForm =
                marketplacePage.querySelector(
                    '.marketplace-products-form'
                );


            /*
            =====================================
                Filter Accordion
            =====================================
            */
            const filterGroups =
                marketplacePage.querySelectorAll(
                    '.filter-group'
                );


            filterGroups.forEach(function (filterGroup) {

                const title =
                    filterGroup.querySelector(
                        '.filter-group-title'
                    );


                if (!title) {
                    return;
                }


                title.addEventListener(
                    'click',
                    function () {

                        const isOpen =
                            filterGroup.classList.contains(
                                'is-open'
                            );


                        filterGroup.classList.toggle(
                            'is-open',
                            !isOpen
                        );


                        title.setAttribute(
                            'aria-expanded',
                            !isOpen ? 'true' : 'false'
                        );

                    }
                );

            });


            /*
            =====================================
                Category / Subcategory Accordion
            =====================================
            */
            const categoryItems =
                marketplacePage.querySelectorAll(
                    '.category-filter-item'
                );


            categoryItems.forEach(function (categoryItem) {

                const toggle =
                    categoryItem.querySelector(
                        '.subcategory-toggle'
                    );


                const subcategoryList =
                    categoryItem.querySelector(
                        '.subcategory-list'
                    );


                if (!toggle || !subcategoryList) {
                    return;
                }


                toggle.addEventListener(
                    'click',
                    function () {

                        const isOpen =
                            categoryItem.classList.contains(
                                'is-open'
                            );


                        categoryItem.classList.toggle(
                            'is-open',
                            !isOpen
                        );


                        toggle.setAttribute(
                            'aria-expanded',
                            !isOpen ? 'true' : 'false'
                        );


                        if (isOpen) {

                            subcategoryList.style.display =
                                'none';

                        } else {

                            subcategoryList.style.display =
                                'block';

                        }

                    }
                );

            });


            /*
            =====================================
                Price Range
            =====================================
            */
            const priceRange =
                marketplacePage.querySelector(
                    '.price-range'
                );


            if (priceRange) {

                const minRange =
                    priceRange.querySelector(
                        '.range-input-min'
                    );


                const maxRange =
                    priceRange.querySelector(
                        '.range-input-max'
                    );


                const minHidden =
                    priceRange.querySelector(
                        '.min-price-input'
                    );


                const maxHidden =
                    priceRange.querySelector(
                        '.max-price-input'
                    );


                const progress =
                    priceRange.querySelector(
                        '.range-progress'
                    );


                const minValue =
                    priceRange.querySelector(
                        '.range-value-min'
                    );


                const maxValue =
                    priceRange.querySelector(
                        '.range-value-max'
                    );


                const minimumGap = 1;


                const formatPrice =
                    function (value) {

                        return '$' +
                            Number(value).toLocaleString();

                    };


                const updatePriceRange =
                    function () {

                        let min =
                            parseFloat(
                                minRange.value
                            );


                        let max =
                            parseFloat(
                                maxRange.value
                            );


                        if (
                            max - min <
                            minimumGap
                        ) {

                            if (
                                document.activeElement ===
                                minRange
                            ) {

                                min =
                                    Math.max(
                                        parseFloat(
                                            minRange.min
                                        ),
                                        max - minimumGap
                                    );

                                minRange.value =
                                    min;

                            } else {

                                max =
                                    Math.min(
                                        parseFloat(
                                            maxRange.max
                                        ),
                                        min + minimumGap
                                    );

                                maxRange.value =
                                    max;

                            }

                        }


                        const rangeMin =
                            parseFloat(
                                minRange.min
                            );


                        const rangeMax =
                            parseFloat(
                                minRange.max
                            );


                        const minPercent =
                            (
                                (min - rangeMin) /
                                (rangeMax - rangeMin)
                            ) * 100;


                        const maxPercent =
                            (
                                (max - rangeMin) /
                                (rangeMax - rangeMin)
                            ) * 100;


                        progress.style.left =
                            minPercent + '%';


                        progress.style.right =
                            (100 - maxPercent) + '%';


                        minValue.textContent =
                            formatPrice(min);


                        maxValue.textContent =
                            max >= rangeMax
                                ? formatPrice(max) + '+'
                                : formatPrice(max);


                        minHidden.value =
                            min;


                        maxHidden.value =
                            max;

                    };


                minRange.addEventListener(
                    'input',
                    updatePriceRange
                );


                maxRange.addEventListener(
                    'input',
                    updatePriceRange
                );


                updatePriceRange();

            }


            /*
            =====================================
                Sort Dropdown
            =====================================
            */
            const sortSelect =
                marketplacePage.querySelector(
                    '.sort-select'
                );


            if (sortSelect) {

                const trigger =
                    sortSelect.querySelector(
                        '.sort-select-trigger'
                    );


                const options =
                    sortSelect.querySelectorAll(
                        '.sort-option'
                    );


                const sortInput =
                    sortSelect.querySelector(
                        '.sort-input'
                    );


                const sortValue =
                    sortSelect.querySelector(
                        '.sort-select-value strong'
                    );


                if (trigger) {

                    trigger.addEventListener(
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


                            trigger.setAttribute(
                                'aria-expanded',
                                !isOpen
                                    ? 'true'
                                    : 'false'
                            );

                        }
                    );

                }


                options.forEach(function (option) {

                    option.addEventListener(
                        'click',
                        function () {

                            const value =
                                option.dataset.value;


                            const label =
                                option.textContent.trim();


                            sortInput.value =
                                value;


                            sortValue.textContent =
                                label;


                            options.forEach(
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


                            trigger.setAttribute(
                                'aria-expanded',
                                'false'
                            );


                            /*
                             * Submit GET request.
                             */
                            if (productsForm) {

                                /*
                                 * Remove current page so
                                 * sorting starts from page 1.
                                 */
                                const pageInput =
                                    productsForm.querySelector(
                                        'input[name="page"]'
                                    );


                                if (pageInput) {

                                    pageInput.remove();

                                }


                                productsForm.submit();

                            }

                        }
                    );

                });


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


                            trigger.setAttribute(
                                'aria-expanded',
                                'false'
                            );

                        }

                    }
                );

            }


            /*
            =====================================
                Category Selection
            =====================================
            */
            const categoryInputs =
                marketplacePage.querySelectorAll(
                    'input[name="category"]'
                );


            categoryInputs.forEach(function (input) {

                input.addEventListener(
                    'change',
                    function () {

                        /*
                         * If a subcategory is selected,
                         * open its parent category.
                         */
                        const categoryItem =
                            input.closest(
                                '.category-filter-item'
                            );


                        if (
                            categoryItem &&
                            input.closest(
                                '.filter-checkbox-subcategory'
                            )
                        ) {

                            categoryItem.classList.add(
                                'is-open'
                            );


                            const toggle =
                                categoryItem.querySelector(
                                    '.subcategory-toggle'
                                );


                            const list =
                                categoryItem.querySelector(
                                    '.subcategory-list'
                                );


                            if (toggle) {

                                toggle.setAttribute(
                                    'aria-expanded',
                                    'true'
                                );

                            }


                            if (list) {

                                list.style.display =
                                    'block';

                            }

                        }

                    }
                );

            });


            /*
            =====================================
                Wishlist UI
            =====================================
            */
            const wishlistButtons =
                marketplacePage.querySelectorAll(
                    '.wishlist'
                );


            wishlistButtons.forEach(
                function (button) {

                    button.addEventListener(
                        'click',
                        function () {

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

                        }
                    );

                }
            );

        });
    </script>

@endpush
