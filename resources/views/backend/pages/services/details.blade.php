@extends('backend.layouts.backend')

@section('title', 'Service Details')

@section('content')

    <div class="service-details-page">

        {{-- ==========================================================
        | Page Header
        =========================================================== --}}

        <div class="service-details-header">

            <div class="service-details-header__left">

                <a
                    href="{{ route('services') }}"
                    class="service-details-back"
                >
                    <i class="fa-regular fa-arrow-left"></i>

                    <span>
                    Back to Services
                </span>
                </a>


                <div class="service-details-title">

                    <div class="service-details-title__icon">
                        <i class="fa-regular fa-truck-fast"></i>
                    </div>

                    <div>

                    <span class="service-details-eyebrow">
                        Service Details
                    </span>

                        <h1>
                            Freight Forwarding
                        </h1>

                        <p>
                            freight-forwarding
                        </p>

                    </div>

                </div>

            </div>


            <div class="service-details-header__actions">

            <span class="service-status service-status--active">

                <i></i>

                Active

            </span>


                <a
                    href="{{ route('service-edit', 1) }}"
                    class="service-details-edit-btn"
                >
                    <i class="fa-regular fa-pen"></i>

                    <span>
                    Edit Service
                </span>
                </a>

            </div>

        </div>


        {{-- ==========================================================
        | Main Layout
        =========================================================== --}}

        <div class="service-details-layout">


            {{-- ======================================================
            | Main Content
            ======================================================= --}}

            <div class="service-details-main">


                {{-- ==================================================
                | Overview
                =================================================== --}}

                <section class="service-details-card">

                    <div class="service-details-card__header">

                        <div>

                            <h2>
                                Service Overview
                            </h2>

                            <p>
                                General information about this service.
                            </p>

                        </div>

                    </div>


                    <div class="service-details-card__body">

                        <div class="service-overview">

                            <div class="service-overview__image">

                                <div class="service-overview__image-placeholder">
                                    <i class="fa-regular fa-truck-fast"></i>
                                </div>

                            </div>


                            <div class="service-overview__content">

                                <h3>
                                    Freight Forwarding
                                </h3>

                                <p class="service-overview__short-description">
                                    Reliable transportation and freight forwarding solutions for domestic and international shipments.
                                </p>


                                <div class="service-overview__meta">

                                    <div>

                                    <span>
                                        Slug
                                    </span>

                                        <strong>
                                            freight-forwarding
                                        </strong>

                                    </div>


                                    <div>

                                    <span>
                                        Created
                                    </span>

                                        <strong>
                                            Aug 01, 2026
                                        </strong>

                                    </div>


                                    <div>

                                    <span>
                                        Last Updated
                                    </span>

                                        <strong>
                                            Aug 13, 2026
                                        </strong>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </section>


                {{-- ==================================================
                | Description
                =================================================== --}}

                <section class="service-details-card">

                    <div class="service-details-card__header">

                        <div>

                            <h2>
                                Description
                            </h2>

                            <p>
                                Detailed information about the service.
                            </p>

                        </div>

                    </div>


                    <div class="service-details-card__body">

                        <div class="service-description">

                            <p>
                                Our freight forwarding service provides reliable and efficient transportation solutions for businesses and individuals. We coordinate the movement of shipments from origin to destination while helping ensure smooth handling throughout the shipping process.
                            </p>

                            <p>
                                The service can include transportation coordination, shipment documentation, carrier management and delivery arrangements depending on the client's requirements.
                            </p>

                        </div>

                    </div>

                </section>


                {{-- ==================================================
                | Pricing
                =================================================== --}}

                <section class="service-details-card">

                    <div class="service-details-card__header">

                        <div>

                            <h2>
                                Pricing
                            </h2>

                            <p>
                                Current pricing configuration for this service.
                            </p>

                        </div>

                    </div>


                    <div class="service-details-card__body">

                        <div class="service-pricing-grid">


                            <div class="service-pricing-item">

                            <span>
                                Price Type
                            </span>

                                <strong>
                                    Starting From
                                </strong>

                            </div>


                            <div class="service-pricing-item">

                            <span>
                                Base Price
                            </span>

                                <strong class="service-pricing-item__price">
                                    $120.00
                                </strong>

                            </div>


                            <div class="service-pricing-item">

                            <span>
                                Currency
                            </span>

                                <strong>
                                    USD
                                </strong>

                            </div>


                            <div class="service-pricing-item">

                            <span>
                                Billing Unit
                            </span>

                                <strong>
                                    Per Shipment
                                </strong>

                            </div>

                        </div>


                        <div class="service-pricing-notice">

                            <div class="service-pricing-notice__icon">
                                <i class="fa-regular fa-circle-info"></i>
                            </div>

                            <div>

                                <strong>
                                    Request pricing
                                </strong>

                                <p>
                                    This base price will be used when a client creates a request. Admin can adjust the final request price when reviewing the shipment.
                                </p>

                            </div>

                        </div>

                    </div>

                </section>


                {{-- ==================================================
                | Recent Requests
                =================================================== --}}

                <section class="service-details-card">

                    <div class="service-details-card__header service-details-card__header--with-action">

                        <div>

                            <h2>
                                Recent Requests
                            </h2>

                            <p>
                                Latest shipment requests using this service.
                            </p>

                        </div>


                        <a
                            href="{{ route('requests') }}"
                            class="service-details-view-all"
                        >
                            View All
                            <i class="fa-regular fa-arrow-right"></i>
                        </a>

                    </div>


                    <div class="service-requests-table-wrapper">

                        <table class="service-requests-table">

                            <thead>

                            <tr>

                                <th>
                                    Request
                                </th>

                                <th>
                                    Client
                                </th>

                                <th>
                                    Price
                                </th>

                                <th>
                                    Status
                                </th>

                                <th>
                                    Date
                                </th>

                            </tr>

                            </thead>


                            <tbody>


                            <tr>

                                <td>

                                    <a
                                        href="#"
                                        class="service-request-number"
                                    >
                                        #REQ-1024
                                    </a>

                                </td>


                                <td>

                                    <div class="service-request-client">

                                        <div class="service-request-client__avatar">
                                            JD
                                        </div>

                                        <span>
                                            John Doe
                                        </span>

                                    </div>

                                </td>


                                <td>

                                    <strong class="service-request-price">
                                        $145.00
                                    </strong>

                                </td>


                                <td>

                                    <span class="request-status request-status--processing">
                                        Processing
                                    </span>

                                </td>


                                <td>

                                    <span class="service-request-date">
                                        Aug 13, 2026
                                    </span>

                                </td>

                            </tr>


                            <tr>

                                <td>

                                    <a
                                        href="#"
                                        class="service-request-number"
                                    >
                                        #REQ-1019
                                    </a>

                                </td>


                                <td>

                                    <div class="service-request-client">

                                        <div class="service-request-client__avatar">
                                            MS
                                        </div>

                                        <span>
                                            Maria Smith
                                        </span>

                                    </div>

                                </td>


                                <td>

                                    <strong class="service-request-price">
                                        $220.00
                                    </strong>

                                </td>


                                <td>

                                    <span class="request-status request-status--completed">
                                        Completed
                                    </span>

                                </td>


                                <td>

                                    <span class="service-request-date">
                                        Aug 11, 2026
                                    </span>

                                </td>

                            </tr>


                            <tr>

                                <td>

                                    <a
                                        href="#"
                                        class="service-request-number"
                                    >
                                        #REQ-1014
                                    </a>

                                </td>


                                <td>

                                    <div class="service-request-client">

                                        <div class="service-request-client__avatar">
                                            RK
                                        </div>

                                        <span>
                                            Robert King
                                        </span>

                                    </div>

                                </td>

                                <td>

                                    <strong class="service-request-price">
                                        $175.00
                                    </strong>

                                </td>


                                <td>

                                    <span class="request-status request-status--pending">
                                        Pending
                                    </span>

                                </td>


                                <td>

                                    <span class="service-request-date">
                                        Aug 09, 2026
                                    </span>

                                </td>

                            </tr>

                            </tbody>

                        </table>

                    </div>

                </section>

            </div>


            {{-- ======================================================
            | Sidebar
            ======================================================= --}}

            <aside class="service-details-sidebar">


                {{-- ==================================================
                | Statistics
                =================================================== --}}

                <div class="service-details-card">

                    <div class="service-details-card__header">

                        <div>

                            <h2>
                                Service Statistics
                            </h2>

                        </div>

                    </div>


                    <div class="service-stat-list">


                        <div class="service-stat-item">

                            <div class="service-stat-item__icon">
                                <i class="fa-regular fa-file-lines"></i>
                            </div>

                            <div>

                            <span>
                                Total Requests
                            </span>

                                <strong>
                                    124
                                </strong>

                            </div>

                        </div>


                        <div class="service-stat-item">

                            <div class="service-stat-item__icon service-stat-item__icon--green">
                                <i class="fa-regular fa-circle-check"></i>
                            </div>

                            <div>

                            <span>
                                Completed
                            </span>

                                <strong>
                                    86
                                </strong>

                            </div>

                        </div>


                        <div class="service-stat-item">

                            <div class="service-stat-item__icon service-stat-item__icon--orange">
                                <i class="fa-regular fa-clock"></i>
                            </div>

                            <div>

                            <span>
                                Processing
                            </span>

                                <strong>
                                    24
                                </strong>

                            </div>

                        </div>


                        <div class="service-stat-item">

                            <div class="service-stat-item__icon service-stat-item__icon--blue">
                                <i class="fa-regular fa-hourglass-half"></i>
                            </div>

                            <div>

                            <span>
                                Pending
                            </span>

                                <strong>
                                    14
                                </strong>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- ==================================================
                | Service Settings
                =================================================== --}}

                <div class="service-details-card">

                    <div class="service-details-card__header">

                        <div>

                            <h2>
                                Service Settings
                            </h2>

                        </div>

                    </div>


                    <div class="service-settings-list">


                        <div class="service-setting-row">

                            <div>

                            <span>
                                Status
                            </span>

                                <strong>
                                    Active
                                </strong>

                            </div>

                            <span class="service-status service-status--active">
                            <i></i>
                            Active
                        </span>

                        </div>


                        <div class="service-setting-row">

                            <div>

                            <span>
                                Featured
                            </span>

                                <strong>
                                    Yes
                                </strong>

                            </div>

                            <span class="service-featured-badge">
                            <i class="fa-solid fa-star"></i>
                            Featured
                        </span>

                        </div>


                        <div class="service-setting-row">

                            <div>

                            <span>
                                Sort Order
                            </span>

                                <strong>
                                    1
                                </strong>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- ==================================================
                | Quick Actions
                =================================================== --}}

                <div class="service-details-card">

                    <div class="service-details-card__header">

                        <div>

                            <h2>
                                Quick Actions
                            </h2>

                        </div>

                    </div>


                    <div class="service-quick-actions">

                        <a
                            href="{{ route('service-edit', 1) }}"
                            class="service-quick-action"
                        >

                        <span class="service-quick-action__icon">
                            <i class="fa-regular fa-pen"></i>
                        </span>

                            <span>
                            Edit Service
                        </span>

                            <i class="fa-regular fa-chevron-right"></i>

                        </a>


                        <button
                            type="button"
                            class="service-quick-action service-quick-action--danger"
                        >

                        <span class="service-quick-action__icon">
                            <i class="fa-regular fa-trash"></i>
                        </span>

                            <span>
                            Delete Service
                        </span>

                            <i class="fa-regular fa-chevron-right"></i>

                        </button>

                    </div>

                </div>

            </aside>

        </div>

    </div>

@endsection
