@extends('backend.layouts.backend')

@section('title', 'Smart Buy Tracking')

@section('content')

    <div class="my-smart-buy-tracking-page">

        {{-- ==========================================================
        | Header
        =========================================================== --}}

        <div class="my-smart-buy-tracking-header">

            <div>

                <a
                    href="{{ route('my-smart-buy-details', $smartBuy) }}"
                    class="my-smart-buy-tracking-back"
                >
                    <i class="ri-arrow-left-line"></i>
                    <span>Back to Request</span>
                </a>


                <div class="my-smart-buy-tracking-heading">

                    <div class="my-smart-buy-tracking-heading__icon">

                        <i class="ri-map-pin-time-line"></i>

                    </div>


                    <div>

                        <span>My Smart Buy</span>

                        <h1>
                            Shipment Tracking
                        </h1>

                        <p>
                            Track the current status and delivery progress of your shipment.
                        </p>

                    </div>

                </div>

            </div>


            <span class="my-smart-buy-tracking-status">

            <i></i>

            In Transit

        </span>

        </div>



        {{-- ==========================================================
        | Tracking Overview
        =========================================================== --}}

        <section class="my-smart-buy-tracking-overview">

            <div class="my-smart-buy-tracking-overview__main">

            <span>
                Tracking Number
            </span>

                <div class="my-smart-buy-tracking-number">

                    <strong id="trackingNumber">
                        DHL-7849236510
                    </strong>

                    <button
                        type="button"
                        id="copyTrackingNumber"
                        class="my-smart-buy-tracking-copy"
                    >

                        <i class="ri-file-copy-line"></i>

                        Copy

                    </button>

                </div>

                <p>
                    DHL Express · Express Shipping
                </p>

            </div>


            <div class="my-smart-buy-tracking-overview__delivery">

            <span>
                Estimated Delivery
            </span>

                <strong>
                    Aug 26, 2026
                </strong>

                <small>
                    9 days remaining
                </small>

            </div>

        </section>



        {{-- ==========================================================
        | Layout
        =========================================================== --}}

        <div class="my-smart-buy-tracking-layout">


            {{-- ======================================================
            | Main Tracking
            ======================================================= --}}

            <div class="my-smart-buy-tracking-main">


                {{-- ==================================================
                | Current Status
                =================================================== --}}

                <section class="my-smart-buy-tracking-card">

                    <div class="my-smart-buy-tracking-card__header">

                        <div>

                            <h2>
                                Current Status
                            </h2>

                            <p>
                                Latest shipment update.
                            </p>

                        </div>


                        <span class="my-smart-buy-tracking-badge is-transit">

                        <i class="ri-truck-line"></i>

                        In Transit

                    </span>

                    </div>


                    <div class="my-smart-buy-tracking-current">

                        <div class="my-smart-buy-tracking-current__icon">

                            <i class="ri-truck-line"></i>

                        </div>


                        <div>

                            <strong>
                                Shipment is on the way
                            </strong>

                            <span>
                            Your shipment is currently in transit to the destination.
                        </span>

                            <small>
                                Last updated: Aug 17, 2026 · 09:42 AM
                            </small>

                        </div>

                    </div>

                </section>



                {{-- ==================================================
                | Tracking Timeline
                =================================================== --}}

                <section class="my-smart-buy-tracking-card">

                    <div class="my-smart-buy-tracking-card__header">

                        <div>

                            <h2>
                                Tracking History
                            </h2>

                            <p>
                                Complete shipment movement history.
                            </p>

                        </div>

                    </div>


                    <div class="my-smart-buy-tracking-timeline">


                        {{-- Delivered --}}

                        <div class="my-smart-buy-tracking-event">

                            <div class="my-smart-buy-tracking-event__marker">

                                <i class="ri-checkbox-circle-line"></i>

                            </div>


                            <div class="my-smart-buy-tracking-event__content">

                                <div>

                                    <strong>
                                        Delivered
                                    </strong>

                                    <span class="is-pending">
                                    Pending
                                </span>

                                </div>

                                <p>
                                    Shipment will be marked delivered after reaching
                                    the destination.
                                </p>

                            </div>

                        </div>



                        {{-- In Transit --}}

                        <div class="my-smart-buy-tracking-event is-current">

                            <div class="my-smart-buy-tracking-event__marker">

                                <i class="ri-truck-line"></i>

                            </div>


                            <div class="my-smart-buy-tracking-event__content">

                                <div>

                                    <strong>
                                        In Transit
                                    </strong>

                                    <span>
                                    Aug 17, 2026 · 09:42 AM
                                </span>

                                </div>

                                <p>
                                    Shipment has departed from the distribution facility
                                    and is on its way to the destination.
                                </p>

                            </div>

                        </div>



                        {{-- Shipment Picked Up --}}

                        <div class="my-smart-buy-tracking-event is-completed">

                            <div class="my-smart-buy-tracking-event__marker">

                                <i class="ri-box-3-line"></i>

                            </div>


                            <div class="my-smart-buy-tracking-event__content">

                                <div>

                                    <strong>
                                        Shipment Picked Up
                                    </strong>

                                    <span>
                                    Aug 16, 2026 · 04:25 PM
                                </span>

                                </div>

                                <p>
                                    Package was collected by the shipping carrier.
                                </p>

                            </div>

                        </div>



                        {{-- Shipment Created --}}

                        <div class="my-smart-buy-tracking-event is-completed">

                            <div class="my-smart-buy-tracking-event__marker">

                                <i class="ri-file-add-line"></i>

                            </div>


                            <div class="my-smart-buy-tracking-event__content">

                                <div>

                                    <strong>
                                        Shipment Created
                                    </strong>

                                    <span>
                                    Aug 16, 2026 · 10:15 AM
                                </span>

                                </div>

                                <p>
                                    Shipment information was created and submitted
                                    to the carrier.
                                </p>

                            </div>

                        </div>



                        {{-- Product Purchased --}}

                        <div class="my-smart-buy-tracking-event is-completed">

                            <div class="my-smart-buy-tracking-event__marker">

                                <i class="ri-shopping-cart-line"></i>

                            </div>


                            <div class="my-smart-buy-tracking-event__content">

                                <div>

                                    <strong>
                                        Product Purchased
                                    </strong>

                                    <span>
                                    Aug 16, 2026 · 08:40 AM
                                </span>

                                </div>

                                <p>
                                    Product was successfully purchased by our team.
                                </p>

                            </div>

                        </div>



                        {{-- Payment Completed --}}

                        <div class="my-smart-buy-tracking-event is-completed">

                            <div class="my-smart-buy-tracking-event__marker">

                                <i class="ri-bank-card-line"></i>

                            </div>


                            <div class="my-smart-buy-tracking-event__content">

                                <div>

                                    <strong>
                                        Payment Completed
                                    </strong>

                                    <span>
                                    Aug 15, 2026 · 06:18 PM
                                </span>

                                </div>

                                <p>
                                    Payment was successfully received and confirmed.
                                </p>

                            </div>

                        </div>

                    </div>

                </section>



                {{-- ==================================================
                | Shipment Updates
                =================================================== --}}

                <section class="my-smart-buy-tracking-card">

                    <div class="my-smart-buy-tracking-card__header">

                        <div>

                            <h2>
                                Shipment Updates
                            </h2>

                            <p>
                                Recent information about your shipment.
                            </p>

                        </div>

                    </div>


                    <div class="my-smart-buy-tracking-updates">

                        <div class="my-smart-buy-tracking-update">

                            <div class="my-smart-buy-tracking-update__icon">

                                <i class="ri-truck-line"></i>

                            </div>


                            <div>

                                <strong>
                                    Shipment departed facility
                                </strong>

                                <span>
                                Aug 17, 2026 · 09:42 AM
                            </span>

                                <p>
                                    Your package has left the distribution facility
                                    and is currently in transit.
                                </p>

                            </div>

                        </div>


                        <div class="my-smart-buy-tracking-update">

                            <div class="my-smart-buy-tracking-update__icon">

                                <i class="ri-map-pin-line"></i>

                            </div>


                            <div>

                                <strong>
                                    Shipment destination confirmed
                                </strong>

                                <span>
                                Aug 16, 2026 · 05:10 PM
                            </span>

                                <p>
                                    Destination address has been confirmed by the
                                    shipping carrier.
                                </p>

                            </div>

                        </div>

                    </div>

                </section>

            </div>



            {{-- ======================================================
            | Sidebar
            ======================================================= --}}

            <aside class="my-smart-buy-tracking-sidebar">


                {{-- ==================================================
                | Shipment Details
                =================================================== --}}

                <section class="my-smart-buy-tracking-card">

                    <div class="my-smart-buy-tracking-card__header">

                        <div>

                            <h2>
                                Shipment Details
                            </h2>

                        </div>

                    </div>


                    <div class="my-smart-buy-tracking-details">

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
                            Tracking Number
                        </span>

                            <strong>
                                DHL-7849236510
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
                            Origin
                        </span>

                            <strong>
                                United States
                            </strong>

                        </div>


                        <div>

                        <span>
                            Destination
                        </span>

                            <strong>
                                Conakry, Guinea
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

                </section>



                {{-- ==================================================
                | Delivery Address
                =================================================== --}}

                <section class="my-smart-buy-tracking-card">

                    <div class="my-smart-buy-tracking-card__header">

                        <div>

                            <h2>
                                Delivery Address
                            </h2>

                        </div>

                    </div>


                    <div class="my-smart-buy-tracking-address">

                        <div class="my-smart-buy-tracking-address__icon">

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
                | Request
                =================================================== --}}

                <section class="my-smart-buy-tracking-card">

                    <div class="my-smart-buy-tracking-card__header">

                        <div>

                            <h2>
                                Request
                            </h2>

                        </div>

                    </div>


                    <div class="my-smart-buy-tracking-request">

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
                            Status
                        </span>

                            <strong class="is-transit">
                                In Transit
                            </strong>

                        </div>


                        <a
                            href="{{ route('my-smart-buy-details', $smartBuy) }}"
                        >

                            View Request

                            <i class="ri-arrow-right-line"></i>

                        </a>

                    </div>

                </section>



                {{-- ==================================================
                | Support
                =================================================== --}}

                <div class="my-smart-buy-tracking-help">

                    <div class="my-smart-buy-tracking-help__icon">

                        <i class="ri-customer-service-2-line"></i>

                    </div>


                    <div>

                        <strong>
                            Need Help?
                        </strong>

                        <p>
                            Contact our support team if you have questions
                            about your shipment.
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
                document.getElementById(
                    'copyTrackingNumber'
                );

            const trackingNumber =
                document.getElementById(
                    'trackingNumber'
                );


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
