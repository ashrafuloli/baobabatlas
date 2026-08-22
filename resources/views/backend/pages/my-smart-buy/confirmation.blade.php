@extends('backend.layouts.backend')

@section('content')

    <div class="smart-buy-confirmation-page">

        <div class="confirmation-wrapper">

            {{--======================================================
                Confirmation Card
            =======================================================--}}
            <div class="confirmation-card">

                {{-- Success Icon --}}
                <div class="confirmation-icon">
                    <i class="ri-check-line"></i>
                </div>


                {{-- Content --}}
                <div class="confirmation-content">

                <span class="confirmation-eyebrow">
                    Smart Buy Request
                </span>

                    <h1>
                        Request Submitted Successfully
                    </h1>

                    <p>
                        Thank you for submitting your Smart Buy request.
                        Our team will review your product details and
                        prepare a quote for you.
                    </p>

                </div>


                {{-- Request Number --}}
                <div class="request-number-card">

                <span>
                    Your Request Number
                </span>

                    <strong>
                        {{ $smartBuy->request_number ?? 'SB-000125' }}
                    </strong>

                    <p>
                        Please keep this number for future reference.
                    </p>

                </div>


                {{-- Next Steps --}}
                <div class="next-steps">

                    <div class="section-heading">

                    <span class="section-eyebrow">
                        What Happens Next
                    </span>

                        <h2>
                            Your Smart Buy Journey
                        </h2>

                    </div>


                    <div class="steps-list">


                        {{-- Step 01 --}}
                        <div class="confirmation-step">

                            <div class="step-icon">
                                <i class="ri-search-eye-line"></i>
                            </div>

                            <div class="step-content">

                                <strong>
                                    Request Review
                                </strong>

                                <p>
                                    Baobab Atlas will review your product
                                    link, quantity, options, and delivery
                                    information.
                                </p>

                            </div>

                        </div>


                        {{-- Step 02 --}}
                        <div class="confirmation-step">

                            <div class="step-icon">
                                <i class="ri-file-text-line"></i>
                            </div>

                            <div class="step-content">

                                <strong>
                                    Quote Preparation
                                </strong>

                                <p>
                                    We'll calculate the product cost,
                                    service fee, shipping, taxes, and
                                    estimated delivery timeframe.
                                </p>

                            </div>

                        </div>


                        {{-- Step 03 --}}
                        <div class="confirmation-step">

                            <div class="step-icon">
                                <i class="ri-mail-check-line"></i>
                            </div>

                            <div class="step-content">

                                <strong>
                                    Quote Ready
                                </strong>

                                <p>
                                    Once your quote is ready, you'll be
                                    able to review the complete cost
                                    breakdown.
                                </p>

                            </div>

                        </div>


                        {{-- Step 04 --}}
                        <div class="confirmation-step">

                            <div class="step-icon">
                                <i class="ri-bank-card-line"></i>
                            </div>

                            <div class="step-content">

                                <strong>
                                    Accept & Pay
                                </strong>

                                <p>
                                    If you approve the quote, you can
                                    securely complete the payment.
                                </p>

                            </div>

                        </div>


                    </div>

                </div>


                {{-- Actions --}}
                <div class="confirmation-actions">

                    <a
                        href="{{ route('my-smart-buy-details', $smartBuy) }}"
                        class="primary-button"
                    >
                        <i class="ri-file-list-3-line"></i>

                        <span>
                        View Request
                    </span>
                    </a>


                    <a
                        href="{{ route('my-smart-buy') }}"
                        class="secondary-button"
                    >
                        <i class="ri-list-check-2"></i>

                        <span>
                        My Smart Buy Requests
                    </span>
                    </a>

                </div>


                {{-- Help Notice --}}
                <div class="confirmation-help">

                    <div class="help-icon">
                        <i class="ri-information-line"></i>
                    </div>

                    <div>

                        <strong>
                            What you need to do now
                        </strong>

                        <p>
                            No payment is required at this stage.
                            Please wait while our team reviews your
                            request and prepares your quote.
                        </p>

                    </div>

                </div>

            </div>


            {{-- Bottom Message --}}
            <div class="confirmation-footer">

            <span>
                YOU FIND IT.
            </span>

                <i class="ri-arrow-right-line"></i>

                <span>
                WE BUY IT.
            </span>

                <i class="ri-arrow-right-line"></i>

                <span>
                WE SHIP IT.
            </span>

            </div>

        </div>

    </div>

@endsection
