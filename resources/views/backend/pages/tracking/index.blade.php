@extends('backend.layouts.backend')

@section('title', 'Tracking')

@section('content')

    <div class="tracking-page">

        {{-- ==========================================================
        | Page Header
        =========================================================== --}}

        <div class="tracking-page__header">

            <div>

            <span class="tracking-page__eyebrow">
                Shipment Tracking
            </span>

                <h1>
                    Tracking
                </h1>

                <p>
                    Search and track shipments using a tracking number.
                </p>

            </div>

        </div>


        {{-- ==========================================================
        | Tracking Search
        =========================================================== --}}

        <section class="tracking-search-card">

            <div class="tracking-search-card__icon">

                <i class="ri-map-pin-time-line"></i>

            </div>


            <div class="tracking-search-card__content">

                <h2>
                    Track Your Shipment
                </h2>

                <p>
                    Enter your tracking number to view the latest shipment status and tracking information.
                </p>


                <form
                    action="#"
                    method="GET"
                    class="tracking-search-form"
                >

                    <div class="tracking-search-input">

                        <i class="ri-search-line"></i>

                        <input
                            type="text"
                            name="tracking_number"
                            value="{{ request('tracking_number') }}"
                            placeholder="Enter tracking number, e.g. BAT-2026-000124"
                            autocomplete="off"
                        >

                    </div>


                    <button
                        type="submit"
                        class="tracking-search-btn"
                    >

                        <i class="ri-search-line"></i>

                        <span>
                        Track Shipment
                    </span>

                    </button>

                </form>


                <div class="tracking-search-help">

                    <i class="ri-information-line"></i>

                    <span>
                    You can find the tracking number in your shipment confirmation.
                </span>

                </div>

            </div>

        </section>



        {{-- ==========================================================
        | Tracking Overview
        =========================================================== --}}

        <div class="tracking-stats">

            {{-- Total Shipments --}}

            <div class="tracking-stat-card">

                <div class="tracking-stat-card__icon">

                    <i class="ri-box-3-line"></i>

                </div>

                <div>

                <span>
                    Total Shipments
                </span>

                    <strong>
                        248
                    </strong>

                </div>

            </div>


            {{-- Active Shipments --}}

            <div class="tracking-stat-card">

                <div class="tracking-stat-card__icon tracking-stat-card__icon--blue">

                    <i class="ri-truck-line"></i>

                </div>

                <div>

                <span>
                    In Transit
                </span>

                    <strong>
                        86
                    </strong>

                </div>

            </div>


            {{-- Delivered --}}

            <div class="tracking-stat-card">

                <div class="tracking-stat-card__icon tracking-stat-card__icon--green">

                    <i class="ri-checkbox-circle-line"></i>

                </div>

                <div>

                <span>
                    Delivered
                </span>

                    <strong>
                        142
                    </strong>

                </div>

            </div>


            {{-- Pending --}}

            <div class="tracking-stat-card">

                <div class="tracking-stat-card__icon tracking-stat-card__icon--orange">

                    <i class="ri-time-line"></i>

                </div>

                <div>

                <span>
                    Pending
                </span>

                    <strong>
                        20
                    </strong>

                </div>

            </div>

        </div>



        {{-- ==========================================================
        | Recent Shipments
        =========================================================== --}}

        <section class="tracking-card">

            <div class="tracking-card__header">

                <div>

                    <h2>
                        Recent Shipments
                    </h2>

                    <p>
                        Recently updated shipment tracking information.
                    </p>

                </div>


                <a
                    href="{{ route('shipments') }}"
                    class="tracking-card__action"
                >

                <span>
                    View All Shipments
                </span>

                    <i class="ri-arrow-right-line"></i>

                </a>

            </div>


            <div class="tracking-table-wrapper">

                <table class="tracking-table">

                    <thead>

                    <tr>

                        <th>
                            Tracking Number
                        </th>

                        <th>
                            Shipment
                        </th>

                        <th>
                            Destination
                        </th>

                        <th>
                            Current Status
                        </th>

                        <th>
                            Last Updated
                        </th>

                        <th>
                            Action
                        </th>

                    </tr>

                    </thead>


                    <tbody>


                    {{-- Shipment 1 --}}

                    <tr>

                        <td>

                            <a
                                href="#"
                                class="tracking-number"
                            >
                                BAT-2026-000124
                            </a>

                        </td>


                        <td>

                            <div class="tracking-shipment">

                                <div class="tracking-shipment__icon">

                                    <i class="ri-box-3-line"></i>

                                </div>

                                <div>

                                    <strong>
                                        Freight Shipment
                                    </strong>

                                    <span>
                                        Freight Forwarding
                                    </span>

                                </div>

                            </div>

                        </td>


                        <td>

                            <div class="tracking-location">

                                <i class="ri-map-pin-line"></i>

                                <span>
                                    Conakry, Guinea
                                </span>

                            </div>

                        </td>


                        <td>

                            <span class="tracking-status tracking-status--transit">

                                <i></i>

                                In Transit

                            </span>

                        </td>


                        <td>

                            <span class="tracking-date">
                                Aug 13, 2026 · 10:42 AM
                            </span>

                        </td>


                        <td>

                            <a
                                href="#"
                                class="tracking-view-btn"
                                aria-label="View shipment"
                            >

                                <i class="ri-eye-line"></i>

                            </a>

                        </td>

                    </tr>


                    {{-- Shipment 2 --}}

                    <tr>

                        <td>

                            <a
                                href="#"
                                class="tracking-number"
                            >
                                BAT-2026-000121
                            </a>

                        </td>


                        <td>

                            <div class="tracking-shipment">

                                <div class="tracking-shipment__icon">

                                    <i class="ri-box-3-line"></i>

                                </div>

                                <div>

                                    <strong>
                                        Document Shipment
                                    </strong>

                                    <span>
                                        Customs Clearance
                                    </span>

                                </div>

                            </div>

                        </td>


                        <td>

                            <div class="tracking-location">

                                <i class="ri-map-pin-line"></i>

                                <span>
                                    Kankan, Guinea
                                </span>

                            </div>

                        </td>


                        <td>

                            <span class="tracking-status tracking-status--delivered">

                                <i></i>

                                Delivered

                            </span>

                        </td>


                        <td>

                            <span class="tracking-date">
                                Aug 12, 2026 · 03:20 PM
                            </span>

                        </td>


                        <td>

                            <a
                                href="#"
                                class="tracking-view-btn"
                                aria-label="View shipment"
                            >

                                <i class="ri-eye-line"></i>

                            </a>

                        </td>

                    </tr>


                    {{-- Shipment 3 --}}

                    <tr>

                        <td>

                            <a
                                href="#"
                                class="tracking-number"
                            >
                                BAT-2026-000118
                            </a>

                        </td>


                        <td>

                            <div class="tracking-shipment">

                                <div class="tracking-shipment__icon">

                                    <i class="ri-box-3-line"></i>

                                </div>

                                <div>

                                    <strong>
                                        Commercial Package
                                    </strong>

                                    <span>
                                        Warehousing
                                    </span>

                                </div>

                            </div>

                        </td>


                        <td>

                            <div class="tracking-location">

                                <i class="ri-map-pin-line"></i>

                                <span>
                                    Nzérékoré, Guinea
                                </span>

                            </div>

                        </td>


                        <td>

                            <span class="tracking-status tracking-status--pending">

                                <i></i>

                                Pending

                            </span>

                        </td>


                        <td>

                            <span class="tracking-date">
                                Aug 11, 2026 · 09:15 AM
                            </span>

                        </td>


                        <td>

                            <a
                                href="#"
                                class="tracking-view-btn"
                                aria-label="View shipment"
                            >

                                <i class="ri-eye-line"></i>

                            </a>

                        </td>

                    </tr>


                    {{-- Shipment 4 --}}

                    <tr>

                        <td>

                            <a
                                href="#"
                                class="tracking-number"
                            >
                                BAT-2026-000115
                            </a>

                        </td>


                        <td>

                            <div class="tracking-shipment">

                                <div class="tracking-shipment__icon">

                                    <i class="ri-box-3-line"></i>

                                </div>

                                <div>

                                    <strong>
                                        Export Package
                                    </strong>

                                    <span>
                                        Freight Forwarding
                                    </span>

                                </div>

                            </div>

                        </td>


                        <td>

                            <div class="tracking-location">

                                <i class="ri-map-pin-line"></i>

                                <span>
                                    Labé, Guinea
                                </span>

                            </div>

                        </td>


                        <td>

                            <span class="tracking-status tracking-status--transit">

                                <i></i>

                                In Transit

                            </span>

                        </td>


                        <td>

                            <span class="tracking-date">
                                Aug 10, 2026 · 04:55 PM
                            </span>

                        </td>


                        <td>

                            <a
                                href="#"
                                class="tracking-view-btn"
                                aria-label="View shipment"
                            >

                                <i class="ri-eye-line"></i>

                            </a>

                        </td>

                    </tr>


                    </tbody>

                </table>

            </div>


            {{-- Table Footer --}}

            <div class="tracking-card__footer">

            <span>
                Showing recent shipment activity
            </span>

                <a href="{{ route('shipments') }}">

                    View all shipments

                    <i class="ri-arrow-right-line"></i>

                </a>

            </div>

        </section>



        {{-- ==========================================================
        | Empty Search State
        | Hidden by default. Can be shown when no tracking result.
        =========================================================== --}}

        <section class="tracking-empty-state">

            <div class="tracking-empty-state__icon">

                <i class="ri-search-line"></i>

            </div>

            <h2>
                No Shipment Found
            </h2>

            <p>
                We couldn't find a shipment with that tracking number.
                Please check the number and try again.
            </p>

        </section>

    </div>

@endsection
