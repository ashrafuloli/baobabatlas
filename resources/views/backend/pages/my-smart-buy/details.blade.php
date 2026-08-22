@extends('backend.layouts.backend')

@section('title', 'Smart Buy Request Details')

@section('content')

    <div class="my-smart-buy-details-page">

        {{-- ==========================================================
        | Header
        =========================================================== --}}

        <div class="my-smart-buy-details-header">

            <div>

                <a
                    href="{{ route('my-smart-buy') }}"
                    class="my-smart-buy-details-back"
                >
                    <i class="ri-arrow-left-line"></i>
                    <span>Back to My Smart Buy</span>
                </a>

                <div class="my-smart-buy-details-heading">

                    <div class="my-smart-buy-details-heading__icon">
                        <i class="ri-shopping-bag-3-line"></i>
                    </div>

                    <div>

                        <span>My Smart Buy</span>

                        <h1>Request Details</h1>

                        <p>
                            Review your Smart Buy request and order progress.
                        </p>

                    </div>

                </div>

            </div>


            <div class="my-smart-buy-details-header__actions">

            <span class="my-smart-buy-details-status">
                <i></i>
                In Transit
            </span>

            </div>

        </div>



        {{-- ==========================================================
        | Request Summary
        =========================================================== --}}

        <section class="my-smart-buy-details-summary">

            <div class="my-smart-buy-details-summary__item">

            <span>
                Request ID
            </span>

                <strong>
                    SB-2026-00128
                </strong>

            </div>


            <div class="my-smart-buy-details-summary__item">

            <span>
                Submitted
            </span>

                <strong>
                    Aug 15, 2026
                </strong>

            </div>


            <div class="my-smart-buy-details-summary__item">

            <span>
                Service
            </span>

                <strong>
                    Smart Buy
                </strong>

            </div>


            <div class="my-smart-buy-details-summary__item">

            <span>
                Current Status
            </span>

                <strong class="is-success">
                    In Transit
                </strong>

            </div>

        </section>



        {{-- ==========================================================
        | Main Layout
        =========================================================== --}}

        <div class="my-smart-buy-details-layout">


            {{-- ======================================================
            | Main
            ======================================================= --}}

            <div class="my-smart-buy-details-main">


                {{-- ==================================================
                | Progress
                =================================================== --}}

                <section class="my-smart-buy-details-card">

                    <div class="my-smart-buy-details-card__header">

                        <div>

                            <h2>
                                Request Progress
                            </h2>

                            <p>
                                Track the progress of your Smart Buy request.
                            </p>

                        </div>

                    </div>


                    <div class="my-smart-buy-details-progress">


                        {{-- Step 1 --}}

                        <div class="my-smart-buy-details-progress__step is-completed">

                            <div class="my-smart-buy-details-progress__icon">

                                <i class="ri-check-line"></i>

                            </div>

                            <div>

                                <strong>
                                    Request Submitted
                                </strong>

                                <span>
                                Aug 15, 2026
                            </span>

                            </div>

                        </div>



                        {{-- Step 2 --}}

                        <div class="my-smart-buy-details-progress__step is-completed">

                            <div class="my-smart-buy-details-progress__icon">

                                <i class="ri-file-list-3-line"></i>

                            </div>

                            <div>

                                <strong>
                                    Quote Approved
                                </strong>

                                <span>
                                Aug 16, 2026
                            </span>

                            </div>

                        </div>



                        {{-- Step 3 --}}

                        <div class="my-smart-buy-details-progress__step is-completed">

                            <div class="my-smart-buy-details-progress__icon">

                                <i class="ri-bank-card-line"></i>

                            </div>

                            <div>

                                <strong>
                                    Payment Completed
                                </strong>

                                <span>
                                Aug 16, 2026
                            </span>

                            </div>

                        </div>



                        {{-- Step 4 --}}

                        <div class="my-smart-buy-details-progress__step is-completed">

                            <div class="my-smart-buy-details-progress__icon">

                                <i class="ri-shopping-cart-line"></i>

                            </div>

                            <div>

                                <strong>
                                    Product Purchased
                                </strong>

                                <span>
                                Aug 16, 2026
                            </span>

                            </div>

                        </div>



                        {{-- Step 5 --}}

                        <div class="my-smart-buy-details-progress__step is-active">

                            <div class="my-smart-buy-details-progress__icon">

                                <i class="ri-truck-line"></i>

                            </div>

                            <div>

                                <strong>
                                    In Transit
                                </strong>

                                <span>
                                Aug 17, 2026
                            </span>

                            </div>

                        </div>



                        {{-- Step 6 --}}

                        <div class="my-smart-buy-details-progress__step">

                            <div class="my-smart-buy-details-progress__icon">

                                <i class="ri-checkbox-circle-line"></i>

                            </div>

                            <div>

                                <strong>
                                    Completed
                                </strong>

                                <span>
                                Pending
                            </span>

                            </div>

                        </div>

                    </div>

                </section>



                {{-- ==================================================
                | Product
                =================================================== --}}

                <section class="my-smart-buy-details-card">

                    <div class="my-smart-buy-details-card__header">

                        <div>

                            <h2>
                                Product Details
                            </h2>

                            <p>
                                Product requested through Smart Buy.
                            </p>

                        </div>

                    </div>


                    <div class="my-smart-buy-details-product">

                        <div class="my-smart-buy-details-product__icon">

                            <i class="ri-macbook-line"></i>

                        </div>


                        <div class="my-smart-buy-details-product__content">

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


                            <div class="my-smart-buy-details-product__meta">

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
                | Quote
                =================================================== --}}

                <section class="my-smart-buy-details-card">

                    <div class="my-smart-buy-details-card__header">

                        <div>

                            <h2>
                                Quote
                            </h2>

                            <p>
                                Approved quote for this request.
                            </p>

                        </div>


                        <span class="my-smart-buy-details-badge is-success">

                        <i class="ri-check-line"></i>

                        Accepted

                    </span>

                    </div>


                    <div class="my-smart-buy-details-quote">

                        <div class="my-smart-buy-details-quote__row">

                        <span>
                            Product Cost
                        </span>

                            <strong>
                                $2,200.00
                            </strong>

                        </div>


                        <div class="my-smart-buy-details-quote__row">

                        <span>
                            Service Fee
                        </span>

                            <strong>
                                $100.00
                            </strong>

                        </div>


                        <div class="my-smart-buy-details-quote__row">

                        <span>
                            Estimated Shipping
                        </span>

                            <strong>
                                $150.00
                            </strong>

                        </div>


                        <div class="my-smart-buy-details-quote__row">

                        <span>
                            Total
                        </span>

                            <strong>
                                $2,450.00
                            </strong>

                        </div>


                        <a
                            href="{{ route('smart-buy-quote', $smartBuy) }}"
                            class="my-smart-buy-details-view-link"
                        >
                            View Full Quote

                            <i class="ri-arrow-right-line"></i>

                        </a>

                    </div>

                </section>



                {{-- ==================================================
                | Payment
                =================================================== --}}

                <section class="my-smart-buy-details-card">

                    <div class="my-smart-buy-details-card__header">

                        <div>

                            <h2>
                                Payment
                            </h2>

                            <p>
                                Payment information for this request.
                            </p>

                        </div>


                        <span class="my-smart-buy-details-badge is-success">

                        <i class="ri-check-line"></i>

                        Paid

                    </span>

                    </div>


                    <div class="my-smart-buy-details-payment">

                        <div class="my-smart-buy-details-payment__icon">

                            <i class="ri-shield-check-line"></i>

                        </div>


                        <div class="my-smart-buy-details-payment__content">

                            <strong>
                                Payment Completed
                            </strong>

                            <span>
                            Aug 16, 2026 · 11:18 AM
                        </span>

                        </div>


                        <div class="my-smart-buy-details-payment__amount">

                        <span>
                            Amount Paid
                        </span>

                            <strong>
                                $2,450.00
                            </strong>

                        </div>

                    </div>

                </section>



                {{-- ==================================================
                | Shipment
                =================================================== --}}

                <section class="my-smart-buy-details-card">

                    <div class="my-smart-buy-details-card__header">

                        <div>

                            <h2>
                                Shipment
                            </h2>

                            <p>
                                Current shipment information.
                            </p>

                        </div>


                        <span class="my-smart-buy-details-badge is-info">

                        <i class="ri-truck-line"></i>

                        In Transit

                    </span>

                    </div>


                    <div class="my-smart-buy-details-shipment">

                        <div class="my-smart-buy-details-shipment__tracking">

                        <span>
                            Tracking Number
                        </span>

                            <strong id="detailsTrackingNumber">
                                DHL-7849236510
                            </strong>


                            <button
                                type="button"
                                id="detailsCopyTracking"
                                class="my-smart-buy-details-copy"
                            >

                                <i class="ri-file-copy-line"></i>

                                Copy

                            </button>

                        </div>


                        <div class="my-smart-buy-details-shipment__grid">

                            <div>

                            <span>
                                Carrier
                            </span>

                                <strong>
                                    DHL Express
                                </strong>

                            </div>


                            <div>

                            <span>
                                Shipping Method
                            </span>

                                <strong>
                                    Express
                                </strong>

                            </div>


                            <div>

                            <span>
                                Shipped On
                            </span>

                                <strong>
                                    Aug 16, 2026
                                </strong>

                            </div>


                            <div>

                            <span>
                                Estimated Delivery
                            </span>

                                <strong>
                                    Aug 26, 2026
                                </strong>

                            </div>

                        </div>


                        <a
                            href="{{ route('smart-buy-tracking', $smartBuy) }}"
                            class="my-smart-buy-details-track-button"
                        >

                            <i class="ri-map-pin-time-line"></i>

                            Track Shipment

                        </a>

                    </div>

                </section>



                {{-- ==================================================
                | Delivery Address
                =================================================== --}}

                <section class="my-smart-buy-details-card">

                    <div class="my-smart-buy-details-card__header">

                        <div>

                            <h2>
                                Delivery Address
                            </h2>

                            <p>
                                Your requested delivery destination.
                            </p>

                        </div>

                    </div>


                    <div class="my-smart-buy-details-address">

                        <div class="my-smart-buy-details-address__icon">

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

            </div>



            {{-- ======================================================
            | Sidebar
            ======================================================= --}}

            <aside class="my-smart-buy-details-sidebar">


                {{-- ==================================================
                | Quick Actions
                =================================================== --}}

                <section class="my-smart-buy-details-card">

                    <div class="my-smart-buy-details-card__header">

                        <div>

                            <h2>
                                Quick Actions
                            </h2>

                        </div>

                    </div>


                    <div class="my-smart-buy-details-actions">


                        {{-- Track Shipment --}}

                        <a
                            href="{{ route('smart-buy-tracking', $smartBuy) }}"
                            class="my-smart-buy-details-action is-primary"
                        >

                            <i class="ri-map-pin-time-line"></i>

                            <span>
                            Track Shipment
                        </span>

                            <i class="ri-arrow-right-s-line"></i>

                        </a>



                        {{-- View Quote --}}

                        <a
                            href="{{ route('smart-buy-quote', $smartBuy) }}"
                            class="my-smart-buy-details-action"
                        >

                            <i class="ri-file-list-3-line"></i>

                            <span>
                            View Quote
                        </span>

                            <i class="ri-arrow-right-s-line"></i>

                        </a>



                        {{-- Payment Details --}}

                        <a
                            href="{{ route('smart-buy-payment', $smartBuy) }}"
                            class="my-smart-buy-details-action"
                        >

                            <i class="ri-receipt-line"></i>

                            <span>
                            Payment Details
                        </span>

                            <i class="ri-arrow-right-s-line"></i>

                        </a>

                    </div>

                </section>



                {{-- ==================================================
                | Request Information
                =================================================== --}}

                <section class="my-smart-buy-details-card">

                    <div class="my-smart-buy-details-card__header">

                        <div>

                            <h2>
                                Request Information
                            </h2>

                        </div>

                    </div>


                    <div class="my-smart-buy-details-request-info">

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
                            Created
                        </span>

                            <strong>
                                Aug 15, 2026
                            </strong>

                        </div>


                        <div>

                        <span>
                            Last Updated
                        </span>

                            <strong>
                                Aug 17, 2026
                            </strong>

                        </div>


                        <div>

                        <span>
                            Status
                        </span>

                            <strong class="is-success">
                                In Transit
                            </strong>

                        </div>

                    </div>

                </section>



                {{-- ==================================================
                | Help
                =================================================== --}}

                <div class="my-smart-buy-details-help">

                    <div class="my-smart-buy-details-help__icon">

                        <i class="ri-customer-service-2-line"></i>

                    </div>


                    <div>

                        <strong>
                            Need Help?
                        </strong>

                        <p>
                            Have a question about your Smart Buy request?
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

            /*
            |--------------------------------------------------------------------------
            | Copy Tracking Number
            |--------------------------------------------------------------------------
            */

            const copyButton =
                document.getElementById('detailsCopyTracking');

            const trackingNumber =
                document.getElementById('detailsTrackingNumber');


            copyButton?.addEventListener(
                'click',
                async function () {

                    if (!trackingNumber) {
                        return;
                    }


                    const value =
                        trackingNumber.textContent.trim();


                    try {

                        if (
                            navigator.clipboard &&
                            window.isSecureContext
                        ) {

                            await navigator.clipboard.writeText(value);

                        } else {

                            const textarea =
                                document.createElement('textarea');

                            textarea.value = value;

                            textarea.style.position = 'fixed';
                            textarea.style.opacity = '0';

                            document.body.appendChild(textarea);

                            textarea.focus();
                            textarea.select();

                            document.execCommand('copy');

                            textarea.remove();

                        }


                        copyButton.innerHTML = `
                    <i class="ri-check-line"></i>
                    Copied
                `;


                    } catch (error) {

                        console.error(
                            'Unable to copy tracking number.',
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
