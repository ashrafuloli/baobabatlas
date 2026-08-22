@extends('backend.layouts.backend')

@section('title', 'Services')

@section('content')

    <div class="services-page">

        {{-- ==========================================================
        | Page Header
        =========================================================== --}}

        <div class="services-page__header">

            <div class="services-page__header-content">

            <span class="services-page__eyebrow">
                Service Management
            </span>

                <h1>
                    Services
                </h1>

                <p>
                    Manage the services available for shipment requests.
                </p>

            </div>


            <div class="services-page__header-actions">

                <a
                    href="{{ route('service-create') }}"
                    class="services-page__add-btn"
                >
                    <i class="fa-regular fa-plus"></i>

                    <span>
                    Add Service
                </span>
                </a>

            </div>

        </div>


        {{-- ==========================================================
        | Statistics
        =========================================================== --}}

        <div class="services-stats">

            {{-- Total --}}

            <div class="services-stat-card">

                <div class="services-stat-card__icon">
                    <i class="fa-regular fa-layer-group"></i>
                </div>

                <div class="services-stat-card__content">

                <span>
                    Total Services
                </span>

                    <strong>
                        8
                    </strong>

                </div>

            </div>


            {{-- Active --}}

            <div class="services-stat-card">

                <div class="services-stat-card__icon services-stat-card__icon--active">
                    <i class="fa-regular fa-circle-check"></i>
                </div>

                <div class="services-stat-card__content">

                <span>
                    Active
                </span>

                    <strong>
                        6
                    </strong>

                </div>

            </div>


            {{-- Inactive --}}

            <div class="services-stat-card">

                <div class="services-stat-card__icon services-stat-card__icon--inactive">
                    <i class="fa-regular fa-circle-pause"></i>
                </div>

                <div class="services-stat-card__content">

                <span>
                    Inactive
                </span>

                    <strong>
                        2
                    </strong>

                </div>

            </div>


            {{-- Featured --}}

            <div class="services-stat-card">

                <div class="services-stat-card__icon services-stat-card__icon--featured">
                    <i class="fa-regular fa-star"></i>
                </div>

                <div class="services-stat-card__content">

                <span>
                    Featured
                </span>

                    <strong>
                        3
                    </strong>

                </div>

            </div>

        </div>


        {{-- ==========================================================
        | Main Card
        =========================================================== --}}

        <div class="services-card">


            {{-- ======================================================
            | Toolbar
            ======================================================= --}}

            <div class="services-card__toolbar">

                <div class="services-card__toolbar-left">

                    <div class="services-search">

                        <i class="fa-regular fa-magnifying-glass"></i>

                        <input
                            type="search"
                            name="search"
                            placeholder="Search services..."
                            aria-label="Search services"
                        >

                    </div>


                    <div class="services-filter">

                        <i class="fa-regular fa-filter"></i>

                        <select
                            name="status"
                            aria-label="Filter by status"
                        >
                            <option value="">
                                All Status
                            </option>

                            <option value="active">
                                Active
                            </option>

                            <option value="inactive">
                                Inactive
                            </option>
                        </select>

                    </div>


                    <div class="services-filter">

                        <i class="fa-regular fa-star"></i>

                        <select
                            name="featured"
                            aria-label="Filter by featured"
                        >
                            <option value="">
                                All Services
                            </option>

                            <option value="featured">
                                Featured
                            </option>

                            <option value="regular">
                                Regular
                            </option>
                        </select>

                    </div>

                </div>


                <div class="services-card__toolbar-right">

                <span class="services-result-count">
                    Showing 8 services
                </span>

                </div>

            </div>


            {{-- ======================================================
            | Table
            ======================================================= --}}

            <div class="services-table-wrapper">

                <table class="services-table">

                    <thead>

                    <tr>

                        <th>
                            Service
                        </th>

                        <th>
                            Price
                        </th>

                        <th>
                            Requests
                        </th>

                        <th>
                            Featured
                        </th>

                        <th>
                            Status
                        </th>

                        <th>
                            Updated
                        </th>

                        <th class="services-table__actions-heading">
                            Actions
                        </th>

                    </tr>

                    </thead>


                    <tbody>


                    {{-- ==================================================
                    | Freight Forwarding
                    =================================================== --}}

                    <tr>

                        <td>

                            <div class="service-table-service">

                                <div class="service-table-service__icon">
                                    <i class="fa-regular fa-truck-fast"></i>
                                </div>

                                <div class="service-table-service__content">

                                    <a href="{{ route('service-details', 1) }}">
                                        Freight Forwarding
                                    </a>

                                    <span>
                                        freight-forwarding
                                    </span>

                                    <p>
                                        Reliable transportation and freight forwarding solutions.
                                    </p>

                                </div>

                            </div>

                        </td>


                        <td>

                            <div class="service-price">

                                <strong>
                                    $120.00
                                </strong>

                                <span>
                                    Starting from
                                </span>

                            </div>

                        </td>


                        <td>

                            <span class="service-request-count">
                                124
                            </span>

                        </td>


                        <td>

                            <span class="service-featured is-featured">

                                <i class="fa-solid fa-star"></i>

                                Featured

                            </span>

                        </td>


                        <td>

                            <span class="service-status service-status--active">

                                <i></i>

                                Active

                            </span>

                        </td>


                        <td>

                            <span class="service-date">
                                Aug 13, 2026
                            </span>

                        </td>


                        <td>

                            <div class="service-actions">

                                <a
                                    href="{{ route('service-details', 1) }}"
                                    class="service-action"
                                    title="View"
                                >
                                    <i class="fa-regular fa-eye"></i>
                                </a>

                                <a
                                    href="{{ route('service-edit', 1) }}"
                                    class="service-action"
                                    title="Edit"
                                >
                                    <i class="fa-regular fa-pen"></i>
                                </a>

                                <button
                                    type="button"
                                    class="service-action service-action--danger"
                                    title="Delete"
                                >
                                    <i class="fa-regular fa-trash"></i>
                                </button>

                            </div>

                        </td>

                    </tr>


                    {{-- ==================================================
                    | Customs Clearance
                    =================================================== --}}

                    <tr>

                        <td>

                            <div class="service-table-service">

                                <div class="service-table-service__icon service-table-service__icon--blue">
                                    <i class="fa-regular fa-file-check"></i>
                                </div>

                                <div class="service-table-service__content">

                                    <a href="{{ route('service-details', 2) }}">
                                        Customs Clearance
                                    </a>

                                    <span>
                                        customs-clearance
                                    </span>

                                    <p>
                                        Professional customs documentation and clearance services.
                                    </p>

                                </div>

                            </div>

                        </td>


                        <td>

                            <div class="service-price">

                                <strong>
                                    $75.00
                                </strong>

                                <span>
                                    Starting from
                                </span>

                            </div>

                        </td>


                        <td>

                            <span class="service-request-count">
                                86
                            </span>

                        </td>


                        <td>

                            <span class="service-featured is-featured">

                                <i class="fa-solid fa-star"></i>

                                Featured

                            </span>

                        </td>


                        <td>

                            <span class="service-status service-status--active">

                                <i></i>

                                Active

                            </span>

                        </td>


                        <td>

                            <span class="service-date">
                                Aug 12, 2026
                            </span>

                        </td>


                        <td>

                            <div class="service-actions">

                                <a
                                    href="{{ route('service-details', 2) }}"
                                    class="service-action"
                                    title="View"
                                >
                                    <i class="fa-regular fa-eye"></i>
                                </a>

                                <a
                                    href="{{ route('service-edit', 2) }}"
                                    class="service-action"
                                    title="Edit"
                                >
                                    <i class="fa-regular fa-pen"></i>
                                </a>

                                <button
                                    type="button"
                                    class="service-action service-action--danger"
                                    title="Delete"
                                >
                                    <i class="fa-regular fa-trash"></i>
                                </button>

                            </div>

                        </td>

                    </tr>


                    {{-- ==================================================
                    | Warehousing
                    =================================================== --}}

                    <tr>

                        <td>

                            <div class="service-table-service">

                                <div class="service-table-service__icon service-table-service__icon--gold">
                                    <i class="fa-regular fa-warehouse"></i>
                                </div>

                                <div class="service-table-service__content">

                                    <a href="{{ route('service-details', 3) }}">
                                        Warehousing
                                    </a>

                                    <span>
                                        warehousing
                                    </span>

                                    <p>
                                        Secure storage and warehouse management solutions.
                                    </p>

                                </div>

                            </div>

                        </td>


                        <td>

                            <div class="service-price">

                                <strong>
                                    $50.00
                                </strong>

                                <span>
                                    Starting from
                                </span>

                            </div>

                        </td>


                        <td>

                            <span class="service-request-count">
                                58
                            </span>

                        </td>


                        <td>

                            <span class="service-featured is-featured">

                                <i class="fa-solid fa-star"></i>

                                Featured

                            </span>

                        </td>


                        <td>

                            <span class="service-status service-status--active">

                                <i></i>

                                Active

                            </span>

                        </td>


                        <td>

                            <span class="service-date">
                                Aug 10, 2026
                            </span>

                        </td>


                        <td>

                            <div class="service-actions">

                                <a
                                    href="{{ route('service-details', 3) }}"
                                    class="service-action"
                                    title="View"
                                >
                                    <i class="fa-regular fa-eye"></i>
                                </a>

                                <a
                                    href="{{ route('service-edit', 3) }}"
                                    class="service-action"
                                    title="Edit"
                                >
                                    <i class="fa-regular fa-pen"></i>
                                </a>

                                <button
                                    type="button"
                                    class="service-action service-action--danger"
                                    title="Delete"
                                >
                                    <i class="fa-regular fa-trash"></i>
                                </button>

                            </div>

                        </td>

                    </tr>


                    {{-- ==================================================
                    | Air Cargo
                    =================================================== --}}

                    <tr>

                        <td>

                            <div class="service-table-service">

                                <div class="service-table-service__icon service-table-service__icon--purple">
                                    <i class="fa-regular fa-plane"></i>
                                </div>

                                <div class="service-table-service__content">

                                    <a href="{{ route('service-details', 4) }}">
                                        Air Cargo
                                    </a>

                                    <span>
                                        air-cargo
                                    </span>

                                    <p>
                                        Fast and flexible air cargo transportation worldwide.
                                    </p>

                                </div>

                            </div>

                        </td>


                        <td>

                            <div class="service-price">

                                <strong>
                                    $180.00
                                </strong>

                                <span>
                                    Starting from
                                </span>

                            </div>

                        </td>


                        <td>

                            <span class="service-request-count">
                                42
                            </span>

                        </td>


                        <td>

                            <span class="service-featured">
                                Regular
                            </span>

                        </td>


                        <td>

                            <span class="service-status service-status--active">

                                <i></i>

                                Active

                            </span>

                        </td>


                        <td>

                            <span class="service-date">
                                Aug 09, 2026
                            </span>

                        </td>


                        <td>

                            <div class="service-actions">

                                <a
                                    href="{{ route('service-details', 4) }}"
                                    class="service-action"
                                    title="View"
                                >
                                    <i class="fa-regular fa-eye"></i>
                                </a>

                                <a
                                    href="{{ route('service-edit', 4) }}"
                                    class="service-action"
                                    title="Edit"
                                >
                                    <i class="fa-regular fa-pen"></i>
                                </a>

                                <button
                                    type="button"
                                    class="service-action service-action--danger"
                                    title="Delete"
                                >
                                    <i class="fa-regular fa-trash"></i>
                                </button>

                            </div>

                        </td>

                    </tr>


                    {{-- ==================================================
                    | Ocean Freight
                    =================================================== --}}

                    <tr>

                        <td>

                            <div class="service-table-service">

                                <div class="service-table-service__icon service-table-service__icon--cyan">
                                    <i class="fa-regular fa-ship"></i>
                                </div>

                                <div class="service-table-service__content">

                                    <a href="{{ route('service-details', 5) }}">
                                        Ocean Freight
                                    </a>

                                    <span>
                                        ocean-freight
                                    </span>

                                    <p>
                                        Cost-effective international sea freight solutions.
                                    </p>

                                </div>

                            </div>

                        </td>


                        <td>

                            <div class="service-price">

                                <strong>
                                    $95.00
                                </strong>

                                <span>
                                    Starting from
                                </span>

                            </div>

                        </td>


                        <td>

                            <span class="service-request-count">
                                37
                            </span>

                        </td>


                        <td>

                            <span class="service-featured">
                                Regular
                            </span>

                        </td>


                        <td>

                            <span class="service-status service-status--active">

                                <i></i>

                                Active

                            </span>

                        </td>


                        <td>

                            <span class="service-date">
                                Aug 07, 2026
                            </span>

                        </td>


                        <td>

                            <div class="service-actions">

                                <a
                                    href="{{ route('service-details', 5) }}"
                                    class="service-action"
                                    title="View"
                                >
                                    <i class="fa-regular fa-eye"></i>
                                </a>

                                <a
                                    href="{{ route('service-edit', 5) }}"
                                    class="service-action"
                                    title="Edit"
                                >
                                    <i class="fa-regular fa-pen"></i>
                                </a>

                                <button
                                    type="button"
                                    class="service-action service-action--danger"
                                    title="Delete"
                                >
                                    <i class="fa-regular fa-trash"></i>
                                </button>

                            </div>

                        </td>

                    </tr>


                    {{-- ==================================================
                    | Packaging
                    =================================================== --}}

                    <tr>

                        <td>

                            <div class="service-table-service">

                                <div class="service-table-service__icon service-table-service__icon--green">
                                    <i class="fa-regular fa-box-open"></i>
                                </div>

                                <div class="service-table-service__content">

                                    <a href="{{ route('service-details', 6) }}">
                                        Packaging
                                    </a>

                                    <span>
                                        packaging
                                    </span>

                                    <p>
                                        Professional packaging and preparation for safe delivery.
                                    </p>

                                </div>

                            </div>

                        </td>


                        <td>

                            <div class="service-price">

                                <strong>
                                    $25.00
                                </strong>

                                <span>
                                    Starting from
                                </span>

                            </div>

                        </td>


                        <td>

                            <span class="service-request-count">
                                29
                            </span>

                        </td>


                        <td>

                            <span class="service-featured">
                                Regular
                            </span>

                        </td>


                        <td>

                            <span class="service-status service-status--inactive">

                                <i></i>

                                Inactive

                            </span>

                        </td>


                        <td>

                            <span class="service-date">
                                Aug 05, 2026
                            </span>

                        </td>


                        <td>

                            <div class="service-actions">

                                <a
                                    href="{{ route('service-details', 6) }}"
                                    class="service-action"
                                    title="View"
                                >
                                    <i class="fa-regular fa-eye"></i>
                                </a>

                                <a
                                    href="{{ route('service-edit', 6) }}"
                                    class="service-action"
                                    title="Edit"
                                >
                                    <i class="fa-regular fa-pen"></i>
                                </a>

                                <button
                                    type="button"
                                    class="service-action service-action--danger"
                                    title="Delete"
                                >
                                    <i class="fa-regular fa-trash"></i>
                                </button>

                            </div>

                        </td>

                    </tr>


                    {{-- ==================================================
                    | Insurance
                    =================================================== --}}

                    <tr>

                        <td>

                            <div class="service-table-service">

                                <div class="service-table-service__icon service-table-service__icon--red">
                                    <i class="fa-regular fa-shield-check"></i>
                                </div>

                                <div class="service-table-service__content">

                                    <a href="{{ route('service-details', 7) }}">
                                        Cargo Insurance
                                    </a>

                                    <span>
                                        cargo-insurance
                                    </span>

                                    <p>
                                        Additional protection for valuable shipments and cargo.
                                    </p>

                                </div>

                            </div>

                        </td>


                        <td>

                            <div class="service-price">

                                <strong>
                                    $15.00
                                </strong>

                                <span>
                                    Starting from
                                </span>

                            </div>

                        </td>


                        <td>

                            <span class="service-request-count">
                                18
                            </span>

                        </td>


                        <td>

                            <span class="service-featured">
                                Regular
                            </span>

                        </td>


                        <td>

                            <span class="service-status service-status--inactive">

                                <i></i>

                                Inactive

                            </span>

                        </td>


                        <td>

                            <span class="service-date">
                                Aug 02, 2026
                            </span>

                        </td>


                        <td>

                            <div class="service-actions">

                                <a
                                    href="{{ route('service-details', 7) }}"
                                    class="service-action"
                                    title="View"
                                >
                                    <i class="fa-regular fa-eye"></i>
                                </a>

                                <a
                                    href="{{ route('service-edit', 7) }}"
                                    class="service-action"
                                    title="Edit"
                                >
                                    <i class="fa-regular fa-pen"></i>
                                </a>

                                <button
                                    type="button"
                                    class="service-action service-action--danger"
                                    title="Delete"
                                >
                                    <i class="fa-regular fa-trash"></i>
                                </button>

                            </div>

                        </td>

                    </tr>


                    {{-- ==================================================
                    | Door to Door
                    =================================================== --}}

                    <tr>

                        <td>

                            <div class="service-table-service">

                                <div class="service-table-service__icon service-table-service__icon--orange">
                                    <i class="fa-regular fa-house"></i>
                                </div>

                                <div class="service-table-service__content">

                                    <a href="{{ route('service-details', 8) }}">
                                        Door to Door Delivery
                                    </a>

                                    <span>
                                        door-to-door-delivery
                                    </span>

                                    <p>
                                        Convenient pickup and delivery directly to the destination.
                                    </p>

                                </div>

                            </div>

                        </td>


                        <td>

                            <div class="service-price">

                                <strong>
                                    $150.00
                                </strong>

                                <span>
                                    Starting from
                                </span>

                            </div>

                        </td>


                        <td>

                            <span class="service-request-count">
                                14
                            </span>

                        </td>


                        <td>

                            <span class="service-featured">
                                Regular
                            </span>

                        </td>


                        <td>

                            <span class="service-status service-status--active">

                                <i></i>

                                Active

                            </span>

                        </td>


                        <td>

                            <span class="service-date">
                                Jul 29, 2026
                            </span>

                        </td>


                        <td>

                            <div class="service-actions">

                                <a
                                    href="{{ route('service-details', 8) }}"
                                    class="service-action"
                                    title="View"
                                >
                                    <i class="fa-regular fa-eye"></i>
                                </a>

                                <a
                                    href="{{ route('service-edit', 8) }}"
                                    class="service-action"
                                    title="Edit"
                                >
                                    <i class="fa-regular fa-pen"></i>
                                </a>

                                <button
                                    type="button"
                                    class="service-action service-action--danger"
                                    title="Delete"
                                >
                                    <i class="fa-regular fa-trash"></i>
                                </button>

                            </div>

                        </td>

                    </tr>

                    </tbody>

                </table>

            </div>


            {{-- ======================================================
            | Empty State
            ======================================================= --}}

            {{--

            <div class="services-empty">

                <div class="services-empty__icon">
                    <i class="fa-regular fa-layer-group"></i>
                </div>

                <h2>
                    No services found
                </h2>

                <p>
                    Create your first service to make it available for shipment requests.
                </p>

                <a
                    href="{{ route('service-create') }}"
                    class="services-page__add-btn"
                >
                    <i class="fa-regular fa-plus"></i>
                    Add Service
                </a>

            </div>

            --}}


            {{-- ======================================================
            | Pagination
            ======================================================= --}}

            <div class="services-pagination">

                <div class="services-pagination__info">

                    Showing

                    <strong>
                        1
                    </strong>

                    to

                    <strong>
                        8
                    </strong>

                    of

                    <strong>
                        8
                    </strong>

                    services

                </div>


                <div class="services-pagination__links">

                    <button
                        type="button"
                        class="services-pagination__button is-disabled"
                        disabled
                    >
                        <i class="fa-regular fa-chevron-left"></i>
                    </button>


                    <button
                        type="button"
                        class="services-pagination__button is-active"
                    >
                        1
                    </button>


                    <button
                        type="button"
                        class="services-pagination__button"
                    >
                        <i class="fa-regular fa-chevron-right"></i>
                    </button>

                </div>

            </div>

        </div>

    </div>

@endsection
