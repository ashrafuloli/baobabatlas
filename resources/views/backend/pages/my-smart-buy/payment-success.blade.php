@extends('backend.layouts.backend')

@section('title', 'Payment Successful')

@section('content')

    <div class="my-smart-buy-payment-result-page">

        {{-- ==========================================================
        | Success Header
        =========================================================== --}}

        <div class="my-smart-buy-payment-result-header">

            <a
                href="{{ route('my-smart-buy-details', $smartBuy) }}"
                class="my-smart-buy-payment-result-back"
            >
                <i class="ri-arrow-left-line"></i>
                <span>Back to Request</span>
            </a>

        </div>



        {{-- ==========================================================
        | Success Card
        =========================================================== --}}

        <section class="my-smart-buy-payment-result-card">

            <div class="my-smart-buy-payment-result-icon">

                <i class="ri-check-line"></i>

            </div>


            <span class="my-smart-buy-payment-result-label">
            Payment Successful
        </span>


            <h1>
                Your payment has been completed!
            </h1>


            <p class="my-smart-buy-payment-result-description">
                Thank you. Your payment has been successfully received.
                We will now proceed with purchasing your requested product.
            </p>



            {{-- ======================================================
            | Payment Details
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

                    <strong class="is-success">
                        Paid
                    </strong>

                </div>


                <div>

                <span>
                    Amount Paid
                </span>

                    <strong>
                        $2,450.00
                    </strong>

                </div>


                <div>

                <span>
                    Payment Date
                </span>

                    <strong>
                        Aug 17, 2026
                    </strong>

                </div>

            </div>



            {{-- ======================================================
            | Payment Reference
            ======================================================= --}}

            <div class="my-smart-buy-payment-result-reference">

                <div>

                <span>
                    Payment Reference
                </span>

                    <strong id="paymentReference">
                        PAY-2026-784923
                    </strong>

                </div>


                <button
                    type="button"
                    id="copyPaymentReference"
                    class="my-smart-buy-payment-result-copy"
                >

                    <i class="ri-file-copy-line"></i>

                    Copy

                </button>

            </div>



            {{-- ======================================================
            | Next Step
            ======================================================= --}}

            <div class="my-smart-buy-payment-result-next">

                <div class="my-smart-buy-payment-result-next__icon">

                    <i class="ri-shopping-cart-2-line"></i>

                </div>


                <div>

                    <strong>
                        What's next?
                    </strong>

                    <p>
                        Our team will purchase the requested product and
                        update your Smart Buy request once the purchase
                        is completed.
                    </p>

                </div>

            </div>



            {{-- ======================================================
            | Actions
            ======================================================= --}}

            <div class="my-smart-buy-payment-result-actions">

                <a
                    href="{{ route('my-smart-buy-details', $smartBuy) }}"
                    class="my-smart-buy-payment-result-primary"
                >

                    <i class="ri-file-list-3-line"></i>

                    View Request

                </a>


                <a
                    href="{{ route('smart-buy-tracking', $smartBuy) }}"
                    class="my-smart-buy-payment-result-secondary"
                >

                    <i class="ri-map-pin-time-line"></i>

                    Track Request

                </a>

            </div>

        </section>



        {{-- ==========================================================
        | Information Cards
        =========================================================== --}}

        <div class="my-smart-buy-payment-result-info-grid">


            {{-- Request Status --}}

            <div class="my-smart-buy-payment-result-info-card">

                <div class="my-smart-buy-payment-result-info-card__icon">

                    <i class="ri-shopping-bag-3-line"></i>

                </div>


                <div>

                <span>
                    Request Status
                </span>

                    <strong>
                        Payment Completed
                    </strong>

                    <p>
                        Your request is ready for the purchasing stage.
                    </p>

                </div>

            </div>



            {{-- Support --}}

            <div class="my-smart-buy-payment-result-info-card">

                <div class="my-smart-buy-payment-result-info-card__icon">

                    <i class="ri-customer-service-2-line"></i>

                </div>


                <div>

                <span>
                    Need Help?
                </span>

                    <strong>
                        Contact Support
                    </strong>

                    <p>
                        Our support team is available if you need assistance.
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


@push('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            /*
            |--------------------------------------------------------------------------
            | Copy Payment Reference
            |--------------------------------------------------------------------------
            */

            const copyButton =
                document.getElementById(
                    'copyPaymentReference'
                );

            const reference =
                document.getElementById(
                    'paymentReference'
                );


            copyButton?.addEventListener(
                'click',
                async function () {

                    if (!reference) {
                        return;
                    }


                    const value =
                        reference.textContent.trim();


                    try {

                        if (
                            navigator.clipboard &&
                            window.isSecureContext
                        ) {

                            await navigator.clipboard.writeText(
                                value
                            );

                        } else {

                            const textarea =
                                document.createElement(
                                    'textarea'
                                );

                            textarea.value = value;

                            textarea.style.position = 'fixed';
                            textarea.style.opacity = '0';

                            document.body.appendChild(
                                textarea
                            );

                            textarea.focus();
                            textarea.select();

                            document.execCommand(
                                'copy'
                            );

                            textarea.remove();

                        }


                        copyButton.innerHTML = `
                    <i class="ri-check-line"></i>
                    Copied
                `;


                    } catch (error) {

                        console.error(
                            'Unable to copy payment reference.',
                            error
                        );

                    }


                    setTimeout(function () {

                        copyButton.innerHTML = `
                    <i class="ri-file-copy-line"></i>
                    Copy
                `;

                    }, 1800);

                }
            );

        });
    </script>

@endpush
