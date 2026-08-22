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
                            <li><span class="current">Contact</span></li>
                        </ul>
                        <h1 class="title">
                            Contact
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="quote-section">
        <div class="container">
            <div class="row m-b-50">
                <div class="col-xl-12">
                    <div class="section-heading text-center">
                        <span class="subtitle">Get a Quote</span>
                        <h2>Request a Shipping Quote</h2>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-xl-8">
                    <div class="quote-card">
                        <form>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Pickup Location</label>
                                        <input type="text" class="form-control" placeholder="Enter pickup address">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Delivery Location</label>
                                        <input type="text" class="form-control" placeholder="Enter destination address">
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Weight (KG)</label>
                                        <input type="number" class="form-control" placeholder="0">
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Vehicle Type</label>

                                        <select class="form-select">
                                            <option>Select Vehicle</option>
                                            <option>Truck</option>
                                            <option>Van</option>
                                            <option>Bike</option>
                                        </select>

                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Delivery Type</label>

                                        <select class="form-select">
                                            <option>Standard</option>
                                            <option>Express</option>
                                            <option>Same Day</option>
                                        </select>

                                    </div>
                                </div>
                            </div>
                            <div class="quote-bottom">
                                <button class="btn btn-theme">
                                    <i class="ri-send-plane-fill"></i>
                                    Get Quote
                                </button>
                            </div>
                        </form>
                    </div>
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
