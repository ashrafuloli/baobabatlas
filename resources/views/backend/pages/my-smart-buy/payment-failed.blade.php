@extends('backend.layouts.backend')

@section('title', 'Payment Failed')

@section('content')

    <div class="my-smart-buy-payment-result-page">

        {{-- ==========================================================
        | Header
        =========================================================== --}}

        <div class="my-smart-buy-payment-result-header">

            <a
                href="{{ route('smart-buy-payment', $smartBuy) }}"
                class="my-smart-buy-payment-result-back"
            >
                <i class="ri-arrow-left-line"></i>
                <span>Back to Payment</span>
            </a>

        </div>



        {{-- ==========================================================
        | Failed Card
        =========================================================== --}}

        <section class="my-smart-buy-payment-result-card is-failed">

            <div class="my-smart-buy-payment-result-icon">

                <i class="ri-close-line"></i>

            </div>


            <span class="my-smart-buy-payment-result-label">
            Payment Failed
        </span>


            <h1>
                We couldn't process your payment
            </h1>


            <p class="my-smart-buy-payment-result-description">
                Your payment was not completed. No amount has been charged
                to your account. Please check your payment details and try again.
            </p>



            {{-- ======================================================
            | Error Notice
            ======================================================= --}}

            <div class="my-smart-buy-payment-failed-notice">

                <div class="my-smart-buy-payment-failed-notice__icon">

                    <i class="ri-error-warning-line"></i>

                </div>


                <div>

                    <strong>
                        Payment could not be completed
                    </strong>

                    <p>
                        The transaction was declined or interrupted before
                        completion. You can safely try again.
                    </p>

                </div>

            </div>



            {{-- ======================================================
            | Transaction Details
            ======================================================= --}}

            <div class="my-smart-buy-payment-result-summary">

                <div>

                <span>
                    Request ID
                </span>

                    <strong>
                        SB-2026-00128
                    </strong>

                </div>


                <div>

                <span>
                    Payment Status
                </span>

                    <strong class="is-failed">
                        Failed
                    </strong>

                </div>


                <div>

                <span>
                    Amount
                </span>

                    <strong>
                        $2,450.00
                    </strong>

                </div>


                <div>

                <span>
                    Attempted
                </span>

                    <strong>
                        Aug 17, 2026
                    </strong>

                </div>

            </div>



            {{-- ======================================================
            | Error Reference
            ======================================================= --}}

            <div class="my-smart-buy-payment-result-reference">

                <div>

                <span>
                    Transaction Reference
                </span>

                    <strong>
                        TXN-2026-784923
                    </strong>

                </div>


                <span class="my-smart-buy-payment-failed-code">
                Payment Declined
            </span>

            </div>



            {{-- ======================================================
            | Try Again
            ======================================================= --}}

            <div class="my-smart-buy-payment-result-actions">

                <a
                    href="{{ route('smart-buy-payment', $smartBuy) }}"
                    class="my-smart-buy-payment-result-primary is-failed"
                >

                    <i class="ri-refresh-line"></i>

                    Try Payment Again

                </a>


                <a
                    href="{{ route('smart-buy-quote', $smartBuy) }}"
                    class="my-smart-buy-payment-result-secondary"
                >

                    <i class="ri-file-list-3-line"></i>

                    Review Quote

                </a>

            </div>

        </section>



        {{-- ==========================================================
        | Helpful Tips
        =========================================================== --}}

        <div class="my-smart-buy-payment-result-info-grid">


            {{-- Tips --}}

            <div class="my-smart-buy-payment-result-info-card">

                <div class="my-smart-buy-payment-result-info-card__icon">

                    <i class="ri-lightbulb-line"></i>

                </div>


                <div>

                <span>
                    Before Trying Again
                </span>

                    <strong>
                        Check your payment details
                    </strong>

                    <ul class="my-smart-buy-payment-failed-tips">

                        <li>
                            Make sure your card number is correct.
                        </li>

                        <li>
                            Check the expiry date and security code.
                        </li>

                        <li>
                            Make sure your card has sufficient funds.
                        </li>

                        <li>
                            Contact your bank if the problem continues.
                        </li>

                    </ul>

                </div>

            </div>



            {{-- Support --}}

            <div class="my-smart-buy-payment-result-info-card">

                <div class="my-smart-buy-payment-result-info-card__icon">

                    <i class="ri-customer-service-2-line"></i>

                </div>


                <div>

                <span>
                    Still Having Trouble?
                </span>

                    <strong>
                        Contact Support
                    </strong>

                    <p>
                        If your payment keeps failing, our support team can
                        help you complete your Smart Buy request.
                    </p>

                    <a href="#">
                        Contact Support
                        <i class="ri-arrow-right-line"></i>
                    </a>

                </div>

            </div>

        </div>

    </div>

@endsection
