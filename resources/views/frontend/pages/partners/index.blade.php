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
                            <li><span class="current">Partners</span></li>
                        </ul>
                        <h1 class="title">
                            Partners
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
