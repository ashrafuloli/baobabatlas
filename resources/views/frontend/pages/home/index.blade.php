@extends('frontend.layouts.frontend')

@section('contents')

<div class="hero-section" style="background-image: url({{asset('assets/img/bg/bg-1.jpg')}});">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xl-6 col-lg-6 col-md-10">
                <div class="hero-content">
                    <p class="sub-title">
                        Fastest & Secure Logistics
                    </p>
                    <h1 class="title">
                        We Deliver your Product Anywhere!
                    </h1>
                    <p class="description">
                        When an unknown printer took a galley of type and company need scra make it better future to
                        make attempt type specimen.
                    </p>
                    <div class="hero-btn">
                        <a href="#" class="btn-1">
                            Our Services <i class="ri-arrow-right-line"></i>
                        </a>
                        <a href="#" class="btn-2">
                            Track Shipment <i class="ri-box-3-line"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6">
                <div class="hero-thumb">
                    <img src="{{asset('assets/img/thumb/thumb-1.png')}}" alt="thumb">
                </div>
            </div>
        </div>
    </div>
</div>

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
                    <span class="subtitle">TRACK YOUR SHIPMENT</span>
                    <h2>Real-time Tracking, Total Peace of Mind</h2>
                </div>
                <form class="tracking-form">

                    <input
                        type="text"
                        placeholder="Enter your tracking number"
                    >

                    <button type="submit">
                        Track Now
                        <i class="ri-box-3-line"></i>
                    </button>

                </form>
            </div>
            <div class="col-xl-6 col-md-5">
                <img src="{{asset('assets/img/thumb/thumb-3.png')}}" alt="thumb">
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
