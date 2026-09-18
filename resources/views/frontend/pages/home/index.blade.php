@extends('frontend.layouts.frontend')

@section('contents')

    <section class="hero-section" style="background-image: url('{{ asset('assets/img/thumb/thumb-2.webp') }}');">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-6 col-lg-7 col-md-7">
                    <div class="hero-content">
                        <p class="sub-title">
                            SHOP THE WORLD
                        </p>

                        <h1 class="title">
                            Whatever you need. Wherever it is. Baobab brings it closer.
                        </h1>

                        <p class="description">
                            Beauty, fashion, electronics, home essentials and more—delivered to Guinea.
                        </p>

                        <div class="hero-btn">
                            <a href="{{route('shop')}}" class="btn-1">
                                Shop Now
                                <i class="ri-arrow-right-line"></i>
                            </a>

                            <a href="{{route('my-smart-buy')}}" class="btn-2">
                                Request an Item
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="marketplace-categories home-categories">
        <div class="container">
            <div class="row m-b-50">
                <div class="col-xl-12">
                    <div class="section-heading text-center">
                        <span class="subtitle">Categories</span>
                        <h2> Shop by Categories</h2>
                    </div>
                </div>
            </div>

            <div class="category-marquee">

                {{-- =========================================
                    First Marquee
                ========================================== --}}
                <div class="category-layout">

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


                {{-- =========================================
                    Second Marquee
                ========================================== --}}
                <div class="category-layout">

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

    <section class="home-cta-section p-t-50">
        <div class="container">
            <div class="home-cta-grid">

                {{-- CTA Card 01 --}}
                <div
                    class="home-cta-card home-cta-card--smarter"
                    style="background-image: url('{{ asset('assets/img/thumb/thumb-4.webp') }}');"
                >
                    <div class="home-cta-content">
                        <h3 class="home-cta-title">
                            Shop Smarter. Live Better.
                        </h3>

                        <p class="home-cta-description">
                            Authentic products. Global choices. Delivered to Guinea.
                        </p>

                        <a href="{{ route('shop') }}" class="home-cta-button">
                            Explore Shop
                        </a>
                    </div>
                </div>

                {{-- CTA Card 02 --}}
                <div
                    class="home-cta-card home-cta-card--brands"
                    style="background-image: url('{{ asset('assets/img/thumb/thumb-5.webp') }}');"
                >
                    <div class="home-cta-content">
                        <h3 class="home-cta-title">
                            Global Brands Closer to Home
                        </h3>

                        <p class="home-cta-description">
                            Quality products for your everyday life.
                        </p>

                        <a href="{{ route('shop') }}" class="home-cta-button">
                            Shop Now
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <section class="home-popular-products p-t-80">
        <div class="container">
            <div class="row m-b-50">
                <div class="col-xl-12">
                    <div class="section-heading text-center">
                        <span class="subtitle">products</span>
                        <h2>Popular This Week</h2>
                    </div>
                </div>
            </div>

            <div class="home-product-grid">
                @forelse ($latestProducts as $product)

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

                        $isWishlisted = in_array(
                            $product->id,
                            $wishlistProductIds ?? [],
                            true
                        );
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
                                class="wishlist {{ $isWishlisted ? 'is-active' : '' }}"
                                data-product-id="{{ $product->id }}"
                                data-product-name="{{ $product->name }}"
                                data-wishlist-url="{{ route('wishlist.toggle', $product) }}"
                                aria-label="{{ $isWishlisted ? 'Remove' : 'Add' }} {{ $product->name }} {{ $isWishlisted ? 'from' : 'to' }} wishlist"
                                aria-pressed="{{ $isWishlisted ? 'true' : 'false' }}"
                            >

                                <i class="{{ $isWishlisted ? 'ri-heart-fill' : 'ri-heart-line' }}"></i>

                            </button>


                            {{-- Product Image --}}
                            <a href="{{ route('shop.details', $product->slug) }}">

                                <img
                                    src="{{ $imageUrl }}"
                                    alt="{{ $product->name }}"
                                    loading="lazy"
                                >

                            </a>

                        </div>
                        <div class="product-content">
                            @if ($product->brand)
                                <span class="product-brand">
                                    {{ $product->brand->name }}
                                </span>
                            @endif


                            <h4>
                                <a href="{{ route('shop.details', $product->slug) }}">
                                    {{ $product->name }}
                                </a>
                            </h4>


                            <strong class="product-price">

                                ${{ number_format( (float) $product->price,2) }}

                            </strong>

                            <div class="read-more">
                                <a href="{{ route('shop.details', $product->slug) }}">
                                    Add to Cart
                                </a>
                            </div>
                        </div>
                    </div>

                @empty
                    <div class="marketplace-empty">

                        <div class="marketplace-empty-icon">
                            <i class="ri-shopping-bag-3-line"></i>
                        </div>

                        <h4>
                            No Products Available
                        </h4>

                        <p>
                            Popular products will appear here.
                        </p>

                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="services-section">
        <div class="container">
            <div class="row m-b-50">
                <div class="col-xl-12">
                    <div class="section-heading text-center">
                        <span class="subtitle">OUR SERVICES</span>
                        <h2>End-to-End Logistics Solutions</h2>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-xl-4 col-md-6 m-b-30">
                    <div class="service-card">
                        <div class="icon">
                            <i class="ri-ship-line"></i>
                        </div>

                        <h3>Freight Forwarding</h3>

                        <p>
                            Sea, air, and land freight solutions tailored to your needs.
                        </p>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6 m-b-30">
                    <div class="service-card">
                        <div class="icon">
                            <i class="ri-file-list-3-line"></i>
                        </div>

                        <h3>Customs Clearance</h3>

                        <p>
                            Efficient customs clearance ensuring smooth border crossings.
                        </p>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6 m-b-30">
                    <div class="service-card">
                        <div class="icon">
                            <i class="ri-store-2-line"></i>
                        </div>

                        <h3>Warehousing</h3>

                        <p>
                            Secure storage solutions with real-time inventory management.
                        </p>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6 m-b-30">
                    <div class="service-card">
                        <div class="icon">
                            <i class="ri-truck-line"></i>
                        </div>

                        <h3>Distribution</h3>

                        <p>
                            Reliable last-mile delivery across Guinea and beyond.
                        </p>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6 m-b-30">
                    <div class="service-card">
                        <div class="icon">
                            <i class="ri-shopping-cart-line"></i>
                        </div>

                        <h3>Marketplace</h3>

                        <p>
                            Buy and sell goods easily through our secure platform.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="how-work-section">
        <div class="container">
            <div class="row m-b-50">
                <div class="col-xl-12">
                    <div class="section-heading text-center">
                        <span class="subtitle">HOW IT WORKS</span>
                        <h2>Simple Steps, Global Impact</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="steps d-none">
                        <div class="step">
                            <div class="step-icon">
                                <i class="ri-file-list-3-line"></i>
                            </div>
                            <div class="step-content">
                                <h3>Request a Quote</h3>
                                <p>
                                    Tell us what you need to ship and get an instant quote.
                                </p>
                            </div>
                        </div>
                        <div class="arrow">
                            <i class="ri-arrow-right-line"></i>
                        </div>
                        <div class="step">
                            <div class="step-icon">
                                <i class="ri-settings-3-line"></i>
                            </div>
                            <div class="step-content">
                                <h3>We Handle the Rest</h3>
                                <p>
                                    We manage your shipment with care and professionalism.
                                </p>
                            </div>
                        </div>
                        <div class="arrow">
                            <i class="ri-arrow-right-line"></i>
                        </div>
                        <div class="step">
                            <div class="step-icon">
                                <i class="ri-checkbox-circle-line"></i>
                            </div>
                            <div class="step-content">
                                <h3>You Receive with Confidence</h3>
                                <p>
                                    Your goods arrive safely, on time, every time.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="how-it-works-steps">

                        <!-- Step 01 -->
                        <div class="step">

                            <div class="icon-wrap">

                                <div class="icon">
                                    <i class="ri-shopping-cart-line"></i>
                                </div>

                                <span class="number">
                                    1
                                </span>

                            </div>

                            <h3 class="step-title">
                                1. Shop or Request
                            </h3>

                        </div>


                        <!-- Step 02 -->
                        <div class="step">

                            <div class="icon-wrap">

                                <div class="icon">
                                    <i class="ri-file-list-3-line"></i>
                                </div>

                                <span class="number">
                        2
                    </span>

                            </div>

                            <h3 class="step-title">
                                2. Get Your Price
                            </h3>

                        </div>


                        <!-- Step 03 -->
                        <div class="step">

                            <div class="icon-wrap">

                                <div class="icon">
                                    <i class="ri-box-3-line"></i>
                                </div>

                                <span class="number">
                        3
                    </span>

                            </div>

                            <h3 class="step-title">
                                3. We Purchase
                            </h3>

                        </div>


                        <!-- Step 04 -->
                        <div class="step">

                            <div class="icon-wrap">

                                <div class="icon">
                                    <i class="ri-home-4-line"></i>
                                </div>

                                <span class="number">
                        4
                    </span>

                            </div>

                            <h3 class="step-title">
                                4. Delivered to You
                            </h3>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="tracking-section">

        <div class="container">

            <div class="row align-items-center">

                <div class="col-xl-6 col-md-7 m-b-xs-30">

                    <div class="section-heading m-b-30">

                    <span class="subtitle">
                        TRACK YOUR SHIPMENT
                    </span>

                        <h2>
                            Real-time Tracking, Total Peace of Mind
                        </h2>

                    </div>


                    <form
                        class="tracking-form"
                        action="{{ route('tracking.search') }}"
                        method="POST"
                    >

                        @csrf

                        <input
                            type="text"
                            name="tracking_number"
                            value="{{ old('tracking_number') }}"
                            placeholder="Enter your tracking number"
                            autocomplete="off"
                            maxlength="255"
                            required
                        >

                        <button type="submit">

                        <span>
                            Track Now
                        </span>

                            <i class="ri-box-3-line"></i>

                        </button>

                    </form>


                    @error('tracking_number')

                    <div class="tracking-validation-error">

                        <i class="ri-error-warning-line"></i>

                        <span>
                            {{ $message }}
                        </span>

                    </div>

                    @enderror

                </div>


                <div class="col-xl-6 col-md-5">

                    <img
                        src="{{ asset('assets/img/thumb/thumb-3.webp') }}"
                        alt="Shipment Tracking"
                    >

                </div>

            </div>

        </div>

    </section>

    <section class="baobab-request-section">
        <div class="container">
            <div class="baobab-request-section__wrapper">

                <div class="row align-items-center">

                    {{-- Content --}}
                    <div class="col-lg-7 col-md-7">
                        <div class="baobab-request-section__content">

                            <h2 class="baobab-request-section__title">
                                Can’t Find What You Need?
                            </h2>

                            <p class="baobab-request-section__description">
                                Send us the product link or tell us what you want.<br>
                                We’ll find it, price it and bring it closer.
                            </p>

                            <div class="baobab-request-section__actions">

                                <a href="http://baobabatlas.test/shop" class="btn-1">
                                    Shop Now
                                    <i class="ri-arrow-right-line"></i>
                                </a>

                                <a href="http://baobabatlas.test/portal/my-smart-buy" class="btn-2">
                                    Request an Item
                                </a>
                            </div>

                        </div>
                    </div>


                    {{-- Image --}}
                    <div class="col-lg-5 col-md-5">
                        <div class="baobab-request-section__visual">

                            <img
                                src="{{ asset('assets/img/thumb/thumb-6.webp') }}"
                                alt="Request a product"
                                class="img-fluid"
                            >

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>

    <section class="faq-section bg-white">
        <div class="container">
            <div class="row m-b-50">
                <div class="col-xl-12">
                    <div class="section-heading text-center">
                        <span class="subtitle">FAQ</span>
                        <h2>Frequently Asked Questions</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="faq-list">
                        <div class="faq-item">
                            <button class="faq-question">
                                <span>How can I get a quote?</span>
                                <i class="ri-add-line"></i>
                            </button>

                            <div class="faq-answer">
                                <div class="inner">
                                    <p>
                                        Simply submit your shipment details through our quote form,
                                        and our team will provide a customized estimate within a
                                        short time.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="faq-item">
                            <button class="faq-question">
                                <span>How long does shipping take?</span>
                                <i class="ri-add-line"></i>
                            </button>

                            <div class="faq-answer">
                                <div class="inner">
                                    <p>
                                        Shipping time depends on the destination and shipping
                                        method. We will provide an estimated delivery date before
                                        dispatch.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="faq-item">
                            <button class="faq-question">
                                <span>What payment methods do you accept?</span>
                                <i class="ri-add-line"></i>
                            </button>

                            <div class="faq-answer">
                                <div class="inner">
                                    <p>
                                        We accept bank transfers, credit/debit cards, PayPal, and
                                        other secure payment options.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="faq-item">
                            <button class="faq-question">
                                <span>Can I track my shipment in real-time?</span>
                                <i class="ri-add-line"></i>
                            </button>

                            <div class="faq-answer">
                                <div class="inner">
                                    <p>
                                        Yes. Every shipment receives a tracking number that allows
                                        you to monitor its progress in real time.
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </section>

@endsection


@push('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const homePage = document.querySelector('body');

            if (!homePage) {
                return;
            }


            /*
            |--------------------------------------------------------------------------
            | Wishlist Button
            |--------------------------------------------------------------------------
            */

            homePage.addEventListener('click', async function (event) {

                const button = event.target.closest(
                    '.home-popular-products .wishlist'
                );

                if (!button || button.disabled) {
                    return;
                }


                event.preventDefault();
                event.stopPropagation();


                const wishlistUrl =
                    button.dataset.wishlistUrl;

                const productId =
                    Number(button.dataset.productId);

                const productName =
                    button.dataset.productName || 'product';


                if (!wishlistUrl || !productId) {
                    return;
                }


                const icon =
                    button.querySelector('i');

                if (!icon) {
                    return;
                }


                const wasWishlisted =
                    button.classList.contains('is-active');


                button.disabled = true;

                button.classList.add('is-loading');


                /*
                |--------------------------------------------------------------------------
                | Loading
                |--------------------------------------------------------------------------
                */

                icon.className =
                    'ri-loader-4-line ri-spin';


                try {

                    const csrfToken =
                        document
                            .querySelector(
                                'meta[name="csrf-token"]'
                            )
                            ?.getAttribute('content') || '';


                    const response =
                        await fetch(
                            wishlistUrl,
                            {
                                method: 'POST',

                                headers: {
                                    'Accept':
                                        'application/json',

                                    'X-Requested-With':
                                        'XMLHttpRequest',

                                    'Content-Type':
                                        'application/json',

                                    'X-CSRF-TOKEN':
                                    csrfToken,
                                },

                                credentials:
                                    'same-origin',
                            }
                        );


                    /*
                    |--------------------------------------------------------------------------
                    | Authentication
                    |--------------------------------------------------------------------------
                    */

                    if (
                        response.status === 401 ||
                        response.status === 419
                    ) {

                        window.location.href =
                            '{{ route('login') }}';

                        return;
                    }


                    const contentType =
                        response.headers.get(
                            'content-type'
                        ) || '';


                    if (
                        !contentType.includes(
                            'application/json'
                        )
                    ) {

                        throw new Error(
                            'Unable to update your wishlist.'
                        );

                    }


                    const data =
                        await response.json();


                    if (!response.ok) {

                        throw new Error(
                            data?.message ||
                            'Unable to update your wishlist.'
                        );

                    }


                    const wishlisted =
                        data.wishlisted === true;


                    /*
                    |--------------------------------------------------------------------------
                    | Update Button
                    |--------------------------------------------------------------------------
                    */

                    button.classList.toggle(
                        'is-active',
                        wishlisted
                    );


                    button.setAttribute(
                        'aria-pressed',
                        wishlisted
                            ? 'true'
                            : 'false'
                    );


                    button.setAttribute(
                        'aria-label',
                        wishlisted
                            ? `Remove ${productName} from wishlist`
                            : `Add ${productName} to wishlist`
                    );


                    icon.className =
                        wishlisted
                            ? 'ri-heart-fill'
                            : 'ri-heart-line';


                    /*
                    |--------------------------------------------------------------------------
                    | Toast
                    |--------------------------------------------------------------------------
                    */

                    if (
                        window.AppToast &&
                        typeof window.AppToast.fire ===
                        'function'
                    ) {

                        window.AppToast.fire({

                            icon: 'success',

                            title:
                                data.message ||
                                (
                                    wishlisted
                                        ? 'Product added to your wishlist.'
                                        : 'Product removed from your wishlist.'
                                ),

                        });

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Global Wishlist Event
                    |--------------------------------------------------------------------------
                    */

                    document.dispatchEvent(
                        new CustomEvent(
                            'wishlist:updated',
                            {
                                detail: {
                                    productId:
                                    productId,

                                    wishlisted:
                                    wishlisted,
                                },
                            }
                        )
                    );

                } catch (error) {

                    /*
                    |--------------------------------------------------------------------------
                    | Restore State
                    |--------------------------------------------------------------------------
                    */

                    button.classList.toggle(
                        'is-active',
                        wasWishlisted
                    );


                    button.setAttribute(
                        'aria-pressed',
                        wasWishlisted
                            ? 'true'
                            : 'false'
                    );


                    icon.className =
                        wasWishlisted
                            ? 'ri-heart-fill'
                            : 'ri-heart-line';


                    /*
                    |--------------------------------------------------------------------------
                    | Error Toast
                    |--------------------------------------------------------------------------
                    */

                    if (
                        window.AppToast &&
                        typeof window.AppToast.fire ===
                        'function'
                    ) {

                        window.AppToast.fire({

                            icon: 'error',

                            title:
                                error.message ||
                                'Unable to update your wishlist.',

                        });

                    }

                } finally {

                    button.disabled = false;

                    button.classList.remove(
                        'is-loading'
                    );

                }

            });

        });
    </script>

@endpush
