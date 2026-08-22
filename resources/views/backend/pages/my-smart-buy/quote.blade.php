@extends('backend.layouts.backend')

@section('title', 'Smart Buy Quote')

@section('content')

    <div class="my-smart-buy-quote-page">

        {{-- ==========================================================
        | Header
        =========================================================== --}}

        <div class="my-smart-buy-quote-header">

            <div>

                <a
                    href="{{ route('my-smart-buy-details', $smartBuy) }}"
                    class="my-smart-buy-quote-back"
                >
                    <i class="ri-arrow-left-line"></i>
                    <span>Back to Request</span>
                </a>


                <div class="my-smart-buy-quote-heading">

                    <div class="my-smart-buy-quote-heading__icon">

                        <i class="ri-file-list-3-line"></i>

                    </div>


                    <div>

                        <span>My Smart Buy</span>

                        <h1>
                            Quote
                        </h1>

                        <p>
                            Review the quote prepared for your Smart Buy request.
                        </p>

                    </div>

                </div>

            </div>


            <span class="my-smart-buy-quote-status is-pending">

            <i></i>

            Awaiting Your Response

        </span>

        </div>



        {{-- ==========================================================
        | Quote Notice
        =========================================================== --}}

        <section class="my-smart-buy-quote-notice">

            <div class="my-smart-buy-quote-notice__icon">

                <i class="ri-information-line"></i>

            </div>


            <div>

                <strong>
                    Your quote is ready
                </strong>

                <p>
                    Please review the quote details below. If everything looks
                    correct, accept the quote to continue to payment.
                </p>

            </div>

        </section>



        {{-- ==========================================================
        | Main Layout
        =========================================================== --}}

        <div class="my-smart-buy-quote-layout">


            {{-- ======================================================
            | Main
            ======================================================= --}}

            <div class="my-smart-buy-quote-main">


                {{-- ==================================================
                | Request Information
                =================================================== --}}

                <section class="my-smart-buy-quote-card">

                    <div class="my-smart-buy-quote-card__header">

                        <div>

                            <h2>
                                Request Information
                            </h2>

                            <p>
                                Details related to your Smart Buy request.
                            </p>

                        </div>

                    </div>


                    <div class="my-smart-buy-quote-request">

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
                            Product
                        </span>

                            <strong>
                                MacBook Pro 14-inch
                            </strong>

                        </div>


                        <div>

                        <span>
                            Quantity
                        </span>

                            <strong>
                                1 Unit
                            </strong>

                        </div>


                        <div>

                        <span>
                            Quote Date
                        </span>

                            <strong>
                                Aug 16, 2026
                            </strong>

                        </div>

                    </div>

                </section>



                {{-- ==================================================
                | Product
                =================================================== --}}

                <section class="my-smart-buy-quote-card">

                    <div class="my-smart-buy-quote-card__header">

                        <div>

                            <h2>
                                Product
                            </h2>

                            <p>
                                Product requested through Smart Buy.
                            </p>

                        </div>

                    </div>


                    <div class="my-smart-buy-quote-product">

                        <div class="my-smart-buy-quote-product__icon">

                            <i class="ri-macbook-line"></i>

                        </div>


                        <div class="my-smart-buy-quote-product__content">

                        <span>
                            Product
                        </span>

                            <h3>
                                MacBook Pro 14-inch
                            </h3>

                            <p>
                                Apple MacBook Pro 14-inch with M-series chip,
                                16GB RAM and 512GB storage.
                            </p>


                            <div class="my-smart-buy-quote-product__meta">

                                <div>

                                <span>
                                    Quantity
                                </span>

                                    <strong>
                                        1 Unit
                                    </strong>

                                </div>


                                <div>

                                <span>
                                    Condition
                                </span>

                                    <strong>
                                        Brand New
                                    </strong>

                                </div>


                                <div>

                                <span>
                                    Category
                                </span>

                                    <strong>
                                        Electronics
                                    </strong>

                                </div>

                            </div>

                        </div>

                    </div>

                </section>



                {{-- ==================================================
                | Quote Breakdown
                =================================================== --}}

                <section class="my-smart-buy-quote-card">

                    <div class="my-smart-buy-quote-card__header">

                        <div>

                            <h2>
                                Quote Breakdown
                            </h2>

                            <p>
                                Complete cost breakdown for your request.
                            </p>

                        </div>

                    </div>


                    <div class="my-smart-buy-quote-breakdown">


                        <div class="my-smart-buy-quote-breakdown__row">

                            <div>

                                <strong>
                                    Product Cost
                                </strong>

                                <span>
                                Cost of requested product
                            </span>

                            </div>

                            <strong>
                                $2,200.00
                            </strong>

                        </div>


                        <div class="my-smart-buy-quote-breakdown__row">

                            <div>

                                <strong>
                                    Smart Buy Service Fee
                                </strong>

                                <span>
                                Service and purchasing assistance
                            </span>

                            </div>

                            <strong>
                                $100.00
                            </strong>

                        </div>


                        <div class="my-smart-buy-quote-breakdown__row">

                            <div>

                                <strong>
                                    Estimated Shipping
                                </strong>

                                <span>
                                Estimated international shipping cost
                            </span>

                            </div>

                            <strong>
                                $150.00
                            </strong>

                        </div>


                        <div class="my-smart-buy-quote-breakdown__row">

                            <div>

                                <strong>
                                    Customs & Handling
                                </strong>

                                <span>
                                Estimated customs and handling charges
                            </span>

                            </div>

                            <strong>
                                $0.00
                            </strong>

                        </div>


                        <div class="my-smart-buy-quote-breakdown__total">

                            <div>

                            <span>
                                Total Quote
                            </span>

                                <small>
                                    Amount required to proceed
                                </small>

                            </div>


                            <strong>
                                $2,450.00
                            </strong>

                        </div>

                    </div>

                </section>



                {{-- ==================================================
                | Delivery Information
                =================================================== --}}

                <section class="my-smart-buy-quote-card">

                    <div class="my-smart-buy-quote-card__header">

                        <div>

                            <h2>
                                Delivery Information
                            </h2>

                            <p>
                                Destination used for this quote.
                            </p>

                        </div>

                    </div>


                    <div class="my-smart-buy-quote-delivery">

                        <div class="my-smart-buy-quote-delivery__icon">

                            <i class="ri-map-pin-line"></i>

                        </div>


                        <div>

                            <strong>
                                John Doe
                            </strong>

                            <p>
                                24 Rue de Paris<br>
                                Conakry, Guinea<br>
                                ZIP: 001
                            </p>

                            <span>
                            +224 600 000 000
                        </span>

                        </div>

                    </div>

                </section>



                {{-- ==================================================
                | Terms
                =================================================== --}}

                <section class="my-smart-buy-quote-card">

                    <div class="my-smart-buy-quote-card__header">

                        <div>

                            <h2>
                                Quote Terms
                            </h2>

                            <p>
                                Please review these important conditions.
                            </p>

                        </div>

                    </div>


                    <div class="my-smart-buy-quote-terms">

                        <div>

                            <i class="ri-checkbox-circle-line"></i>

                            <span>
                            This quote is valid for 7 days from the quote date.
                        </span>

                        </div>


                        <div>

                            <i class="ri-checkbox-circle-line"></i>

                            <span>
                            Shipping costs are estimated and may change if the
                            actual shipping cost differs.
                        </span>

                        </div>


                        <div>

                            <i class="ri-checkbox-circle-line"></i>

                            <span>
                            Additional customs or government charges may apply
                            where applicable.
                        </span>

                        </div>


                        <div>

                            <i class="ri-checkbox-circle-line"></i>

                            <span>
                            Product availability is subject to supplier
                            availability at the time of purchase.
                        </span>

                        </div>

                    </div>

                </section>

            </div>



            {{-- ======================================================
            | Sidebar
            ======================================================= --}}

            <aside class="my-smart-buy-quote-sidebar">


                {{-- ==================================================
                | Quote Summary
                =================================================== --}}

                <section class="my-smart-buy-quote-card">

                    <div class="my-smart-buy-quote-card__header">

                        <div>

                            <h2>
                                Quote Summary
                            </h2>

                        </div>

                    </div>


                    <div class="my-smart-buy-quote-summary">

                        <div>

                        <span>
                            Product Cost
                        </span>

                            <strong>
                                $2,200.00
                            </strong>

                        </div>


                        <div>

                        <span>
                            Service Fee
                        </span>

                            <strong>
                                $100.00
                            </strong>

                        </div>


                        <div>

                        <span>
                            Shipping
                        </span>

                            <strong>
                                $150.00
                            </strong>

                        </div>


                        <div class="is-total">

                        <span>
                            Total
                        </span>

                            <strong>
                                $2,450.00
                            </strong>

                        </div>

                    </div>


                    {{-- Accept Quote --}}

                    <div class="my-smart-buy-quote-action">

                        <form
                            action="{{ route('smart-buy-quote-accept', $smartBuy) }}"
                            method="POST"
                        >

                            @csrf

                            <button
                                type="submit"
                                class="my-smart-buy-quote-accept"
                                id="acceptQuoteButton"
                            >

                                <i class="ri-check-line"></i>

                                <span>
                                Accept Quote
                            </span>

                            </button>

                        </form>


                        <a
                            href="{{ route('my-smart-buy-details', $smartBuy) }}"
                            class="my-smart-buy-quote-secondary"
                        >

                            <i class="ri-arrow-left-line"></i>

                            Back to Request

                        </a>

                    </div>

                </section>



                {{-- ==================================================
                | Quote Status
                =================================================== --}}

                <section class="my-smart-buy-quote-card">

                    <div class="my-smart-buy-quote-card__header">

                        <div>

                            <h2>
                                Quote Status
                            </h2>

                        </div>

                    </div>


                    <div class="my-smart-buy-quote-status-card">

                        <div class="my-smart-buy-quote-status-card__icon">

                            <i class="ri-time-line"></i>

                        </div>


                        <div>

                            <strong>
                                Awaiting Your Response
                            </strong>

                            <span>
                            Valid until Aug 23, 2026
                        </span>

                        </div>

                    </div>

                </section>



                {{-- ==================================================
                | Support
                =================================================== --}}

                <div class="my-smart-buy-quote-help">

                    <div class="my-smart-buy-quote-help__icon">

                        <i class="ri-customer-service-2-line"></i>

                    </div>


                    <div>

                        <strong>
                            Have Questions?
                        </strong>

                        <p>
                            Contact our support team before accepting the quote.
                        </p>

                        <a href="#">
                            Contact Support
                            <i class="ri-arrow-right-line"></i>
                        </a>

                    </div>

                </div>

            </aside>

        </div>

    </div>

@endsection


@push('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const form =
                document.querySelector(
                    '.my-smart-buy-quote-action form'
                );

            const button =
                document.getElementById('acceptQuoteButton');


            if (!form || !button) {
                return;
            }


            form.addEventListener('submit', function (event) {

                const confirmed = window.confirm(
                    'Are you sure you want to accept this quote and continue to payment?'
                );


                if (!confirmed) {

                    event.preventDefault();

                    return;

                }


                button.disabled = true;

                button.innerHTML = `
            <i class="ri-loader-4-line"></i>
            <span>Processing...</span>
        `;

            });

        });
    </script>

@endpush
