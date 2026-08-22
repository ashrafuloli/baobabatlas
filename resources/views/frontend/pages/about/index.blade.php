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
                            <li><span class="current">About</span></li>
                        </ul>
                        <h1 class="title">
                            About
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="about-section">
        <div class="about-container">

            <div class="about-image">
                <img
                    src="{{ asset('assets/img/thumb/thumb-1.png') }}"
                    alt="Baobab Atlas team"
                >
            </div>

            <div class="about-content">

            <span class="section-label">
                ABOUT US
            </span>

                <h1>
                    Building Better Ideas, Together.
                </h1>

                <p>
                    We are a passionate team dedicated to helping businesses grow
                    through thoughtful solutions, creative ideas, and meaningful
                    experiences.
                </p>

                <p>
                    Our approach is simple: understand what matters to our clients,
                    create solutions that make a difference, and build long-term
                    relationships based on trust and results.
                </p>

                <a href="#mission" class="about-btn">
                    <span>Discover More</span>
                    <i class="ri-arrow-right-line"></i>
                </a>

            </div>

        </div>
    </section>

    <section class="mission-vision" id="mission">

        <div class="about-container">

            <div class="mv-heading">

            <span class="section-label">
                WHAT DRIVES US
            </span>

                <h2>
                    Our Mission &amp; Vision
                </h2>

                <p>
                    We believe great work starts with a clear purpose and a vision
                    for something better.
                </p>

            </div>


            <div class="mv-grid">

                <!-- Mission -->
                <div class="mv-card mission-card">

                    <div class="mv-icon">
                        <i class="ri-focus-3-line"></i>
                    </div>

                    <span class="card-label">
                    OUR MISSION
                </span>

                    <h3>
                        Creating Meaningful Solutions
                    </h3>

                    <p>
                        Our mission is to deliver reliable, innovative, and impactful
                        solutions that help our clients achieve their goals and move
                        their businesses forward.
                    </p>

                </div>


                <!-- Vision -->
                <div class="mv-card vision-card">

                    <div class="mv-icon">
                        <i class="ri-eye-line"></i>
                    </div>

                    <span class="card-label">
                    OUR VISION
                </span>

                    <h3>
                        A Better Future Through Innovation
                    </h3>

                    <p>
                        Our vision is to become a trusted partner for businesses around
                        the world by continuously improving, embracing innovation, and
                        creating lasting value.
                    </p>

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
                            <a href="#">
                                Request a Quote <i class="ri-arrow-right-line"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
