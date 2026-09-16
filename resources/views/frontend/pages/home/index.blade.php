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
                    <div class="steps">
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

    <section class="faq-section">
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

    <section class="cta-section">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="cta-content">
                        <div class="section-heading text-center">
                            <span class="subtitle">Get In Touch</span>
                            <h2>Need a custom solution?</h2>
                            <p class="description">
                                We are here to help your business growth globally.
                            </p>
                        </div>

                        <div class="cta-btn">
                            <a href="{{route('contact')}}">
                                Request a Quote <i class="ri-arrow-right-line"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
