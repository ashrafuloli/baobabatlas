@extends('backend.layouts.backend')

@section('title', 'Tracking Details')

@section('content')

    <div class="tracking-details-page">

        {{-- ==========================================================
        | Page Header
        =========================================================== --}}

        <div class="tracking-details-header">

            <div class="tracking-details-header__left">

                <a
                    href="{{ route('tracking') }}"
                    class="tracking-details-back"
                >
                    <i class="ri-arrow-left-line"></i>

                    <span>
                    Back to Tracking
                </span>
                </a>


                <div class="tracking-details-title">

                    <div class="tracking-details-title__icon">

                        <i class="ri-map-pin-time-line"></i>

                    </div>


                    <div>

                    <span class="tracking-details-eyebrow">
                        Shipment Tracking
                    </span>

                        <h1>
                            BAT-2026-000124
                        </h1>

                        <p>
                            Freight Forwarding Shipment
                        </p>

                    </div>

                </div>

            </div>


            <div class="tracking-details-header__actions">

            <span class="tracking-details-status tracking-details-status--transit">

                <i></i>

                In Transit

            </span>


                <a
                    href="{{ route('shipment-details') }}"
                    class="tracking-details-action"
                >

                    <i class="ri-eye-line"></i>

                    <span>
                    Shipment Details
                </span>

                </a>

            </div>

        </div>



        {{-- ==========================================================
        | Main Layout
        =========================================================== --}}

        <div class="tracking-details-layout">


            {{-- ======================================================
            | Main Content
            ======================================================= --}}

            <div class="tracking-details-main">


                {{-- ==================================================
                | Current Status
                =================================================== --}}

                <section class="tracking-status-card">

                    <div class="tracking-status-card__top">

                        <div>

                        <span class="tracking-status-card__label">
                            Current Status
                        </span>

                            <h2>
                                In Transit
                            </h2>

                            <p>
                                Your shipment is currently on its way to the destination.
                            </p>

                        </div>


                        <div class="tracking-status-card__icon">

                            <i class="ri-truck-line"></i>

                        </div>

                    </div>


                    <div class="tracking-status-card__progress">

                        <div class="tracking-progress">

                            <div class="tracking-progress__line">

                            <span
                                class="tracking-progress__fill"
                                style="width: 68%;"
                            ></span>

                            </div>


                            <div class="tracking-progress__steps">

                                <div class="tracking-progress-step tracking-progress-step--completed">

                                <span>
                                    <i class="ri-check-line"></i>
                                </span>

                                    <strong>
                                        Request
                                    </strong>

                                </div>


                                <div class="tracking-progress-step tracking-progress-step--completed">

                                <span>
                                    <i class="ri-check-line"></i>
                                </span>

                                    <strong>
                                        Picked Up
                                    </strong>

                                </div>


                                <div class="tracking-progress-step tracking-progress-step--active">

                                <span>
                                    <i class="ri-truck-line"></i>
                                </span>

                                    <strong>
                                        In Transit
                                    </strong>

                                </div>


                                <div class="tracking-progress-step">

                                <span>
                                    <i class="ri-map-pin-line"></i>
                                </span>

                                    <strong>
                                        Delivered
                                    </strong>

                                </div>

                            </div>

                        </div>

                    </div>


                    <div class="tracking-status-card__footer">

                        <div>

                        <span>
                            Last Updated
                        </span>

                            <strong>
                                Aug 13, 2026 · 10:42 AM
                            </strong>

                        </div>


                        <div>

                        <span>
                            Estimated Delivery
                        </span>

                            <strong>
                                Aug 16, 2026
                            </strong>

                        </div>

                    </div>

                </section>



                {{-- ==================================================
                | Tracking Timeline
                =================================================== --}}

                <section class="tracking-details-card">

                    <div class="tracking-details-card__header">

                        <div>

                            <h2>
                                Tracking History
                            </h2>

                            <p>
                                Complete shipment movement and status updates.
                            </p>

                        </div>

                    </div>


                    <div class="tracking-timeline">


                        {{-- Current Event --}}

                        <div class="tracking-timeline-item tracking-timeline-item--current">

                            <div class="tracking-timeline-item__indicator">

                            <span>

                                <i class="ri-truck-line"></i>

                            </span>

                            </div>


                            <div class="tracking-timeline-item__content">

                                <div class="tracking-timeline-item__top">

                                    <div>

                                        <h3>
                                            Shipment in Transit
                                        </h3>

                                        <span>
                                        Conakry, Guinea
                                    </span>

                                    </div>

                                    <time>
                                        Aug 13, 2026 · 10:42 AM
                                    </time>

                                </div>


                                <p>
                                    Shipment has departed from the current facility and is currently in transit to the destination.
                                </p>

                            </div>

                        </div>



                        {{-- Event 2 --}}

                        <div class="tracking-timeline-item">

                            <div class="tracking-timeline-item__indicator">

                            <span>
                                <i class="ri-checkbox-circle-line"></i>
                            </span>

                            </div>


                            <div class="tracking-timeline-item__content">

                                <div class="tracking-timeline-item__top">

                                    <div>

                                        <h3>
                                            Shipment Picked Up
                                        </h3>

                                        <span>
                                        Conakry, Guinea
                                    </span>

                                    </div>

                                    <time>
                                        Aug 12, 2026 · 02:15 PM
                                    </time>

                                </div>


                                <p>
                                    Shipment was successfully collected from the sender.
                                </p>

                            </div>

                        </div>



                        {{-- Event 3 --}}

                        <div class="tracking-timeline-item">

                            <div class="tracking-timeline-item__indicator">

                            <span>
                                <i class="ri-file-check-line"></i>
                            </span>

                            </div>


                            <div class="tracking-timeline-item__content">

                                <div class="tracking-timeline-item__top">

                                    <div>

                                        <h3>
                                            Shipment Confirmed
                                        </h3>

                                        <span>
                                        Baobab Atlas Processing Center
                                    </span>

                                    </div>

                                    <time>
                                        Aug 11, 2026 · 11:20 AM
                                    </time>

                                </div>


                                <p>
                                    Shipment request was reviewed and confirmed for processing.
                                </p>

                            </div>

                        </div>



                        {{-- Event 4 --}}

                        <div class="tracking-timeline-item">

                            <div class="tracking-timeline-item__indicator">

                            <span>
                                <i class="ri-file-list-3-line"></i>
                            </span>

                            </div>


                            <div class="tracking-timeline-item__content">

                                <div class="tracking-timeline-item__top">

                                    <div>

                                        <h3>
                                            Request Created
                                        </h3>

                                        <span>
                                        Online Portal
                                    </span>

                                    </div>

                                    <time>
                                        Aug 10, 2026 · 09:35 AM
                                    </time>

                                </div>


                                <p>
                                    Shipment request was successfully created by the client.
                                </p>

                            </div>

                        </div>


                    </div>

                </section>



                {{-- ==================================================
                | Shipment Information
                =================================================== --}}

                <section class="tracking-details-card">

                    <div class="tracking-details-card__header">

                        <div>

                            <h2>
                                Shipment Information
                            </h2>

                            <p>
                                Basic information about this shipment.
                            </p>

                        </div>

                    </div>


                    <div class="tracking-info-grid">


                        <div class="tracking-info-item">

                        <span>
                            Tracking Number
                        </span>

                            <strong>
                                BAT-2026-000124
                            </strong>

                        </div>


                        <div class="tracking-info-item">

                        <span>
                            Service
                        </span>

                            <strong>
                                Freight Forwarding
                            </strong>

                        </div>


                        <div class="tracking-info-item">

                        <span>
                            Origin
                        </span>

                            <strong>
                                Conakry, Guinea
                            </strong>

                        </div>


                        <div class="tracking-info-item">

                        <span>
                            Destination
                        </span>

                            <strong>
                                Paris, France
                            </strong>

                        </div>


                        <div class="tracking-info-item">

                        <span>
                            Shipment Date
                        </span>

                            <strong>
                                Aug 10, 2026
                            </strong>

                        </div>


                        <div class="tracking-info-item">

                        <span>
                            Estimated Delivery
                        </span>

                            <strong>
                                Aug 16, 2026
                            </strong>

                        </div>


                        <div class="tracking-info-item">

                        <span>
                            Package Type
                        </span>

                            <strong>
                                Commercial Package
                            </strong>

                        </div>


                        <div class="tracking-info-item">

                        <span>
                            Weight
                        </span>

                            <strong>
                                24.5 kg
                            </strong>

                        </div>

                    </div>

                </section>

            </div>



            {{-- ======================================================
            | Sidebar
            ======================================================= --}}

            <aside class="tracking-details-sidebar">


                {{-- ==================================================
                | Client
                =================================================== --}}

                <section class="tracking-details-card">

                    <div class="tracking-details-card__header">

                        <div>

                            <h2>
                                Client
                            </h2>

                        </div>

                    </div>


                    <div class="tracking-client">

                        <div class="tracking-client__avatar">
                            JD
                        </div>


                        <div class="tracking-client__info">

                            <strong>
                                John Doe
                            </strong>

                            <span>
                            Client
                        </span>

                        </div>

                    </div>


                    <div class="tracking-client__details">

                        <div>

                            <i class="ri-mail-line"></i>

                            <span>
                            john@example.com
                        </span>

                        </div>


                        <div>

                            <i class="ri-phone-line"></i>

                            <span>
                            +224 620 000 000
                        </span>

                        </div>

                    </div>

                </section>



                {{-- ==================================================
                | Route
                =================================================== --}}

                <section class="tracking-details-card">

                    <div class="tracking-details-card__header">

                        <div>

                            <h2>
                                Shipment Route
                            </h2>

                        </div>

                    </div>


                    <div class="tracking-route">

                        <div class="tracking-route__item">

                            <div class="tracking-route__marker tracking-route__marker--origin">

                                <i class="ri-map-pin-line"></i>

                            </div>


                            <div>

                            <span>
                                Origin
                            </span>

                                <strong>
                                    Conakry
                                </strong>

                                <small>
                                    Guinea
                                </small>

                            </div>

                        </div>


                        <div class="tracking-route__line"></div>


                        <div class="tracking-route__item">

                            <div class="tracking-route__marker tracking-route__marker--destination">

                                <i class="ri-flag-line"></i>

                            </div>


                            <div>

                            <span>
                                Destination
                            </span>

                                <strong>
                                    Paris
                                </strong>

                                <small>
                                    France
                                </small>

                            </div>

                        </div>

                    </div>

                </section>



                {{-- ==================================================
                | Package Details
                =================================================== --}}

                <section class="tracking-details-card">

                    <div class="tracking-details-card__header">

                        <div>

                            <h2>
                                Package Details
                            </h2>

                        </div>

                    </div>


                    <div class="tracking-package-list">


                        <div>

                        <span>
                            Package Type
                        </span>

                            <strong>
                                Commercial
                            </strong>

                        </div>


                        <div>

                        <span>
                            Quantity
                        </span>

                            <strong>
                                4 Packages
                            </strong>

                        </div>


                        <div>

                        <span>
                            Total Weight
                        </span>

                            <strong>
                                24.5 kg
                            </strong>

                        </div>


                        <div>

                        <span>
                            Shipping Method
                        </span>

                            <strong>
                                Air Freight
                            </strong>

                        </div>

                    </div>

                </section>



                {{-- ==================================================
                | Actions
                =================================================== --}}

                <section class="tracking-details-card">

                    <div class="tracking-details-card__header">

                        <div>

                            <h2>
                                Quick Actions
                            </h2>

                        </div>

                    </div>


                    <div class="tracking-actions">

                        <a
                            href="{{ route('shipment-details') }}"
                            class="tracking-action"
                        >

                        <span class="tracking-action__icon">

                            <i class="ri-box-3-line"></i>

                        </span>

                            <span>
                            View Shipment
                        </span>

                            <i class="ri-arrow-right-s-line"></i>

                        </a>


                        <a
                            href="#"
                            class="tracking-action"
                        >

                        <span class="tracking-action__icon">

                            <i class="ri-printer-line"></i>

                        </span>

                            <span>
                            Print Tracking
                        </span>

                            <i class="ri-arrow-right-s-line"></i>

                        </a>

                    </div>

                </section>

            </aside>

        </div>

    </div>

@endsection
