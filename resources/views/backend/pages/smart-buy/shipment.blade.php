@extends('backend.layouts.backend')

@section('title', 'Create Shipment')

@section('content')

    <div class="smart-buy-shipment-page">

        {{-- ==========================================================
        | Page Header
        =========================================================== --}}

        <div class="smart-buy-shipment-header">

            <div>

                <a
                    href="{{ route('smart-buy-details', 1) }}"
                    class="smart-buy-shipment-back"
                >
                    <i class="ri-arrow-left-line"></i>
                    <span>Back to Request Details</span>
                </a>


                <div class="smart-buy-shipment-heading">

                    <div class="smart-buy-shipment-heading__icon">
                        <i class="ri-truck-line"></i>
                    </div>


                    <div>

                        <span>Smart Buy</span>

                        <h1>Create Shipment</h1>

                        <p>
                            Create shipment and add tracking information for
                            SB-2026-00128.
                        </p>

                    </div>

                </div>

            </div>


            <span class="smart-buy-shipment-status">

            <i></i>

            Product Purchased

        </span>

        </div>



        {{-- ==========================================================
        | Form
        =========================================================== --}}

        <form
            id="smartBuyShipmentForm"
            class="smart-buy-shipment-form"
            method="POST"
            action="{{ route('smart-buy-shipment', 1) }}"
        >

            @csrf


            <div class="smart-buy-shipment-layout">


                {{-- ==================================================
                | Main Content
                =================================================== --}}

                <div class="smart-buy-shipment-main">


                    {{-- ==================================================
                    | Shipment Details
                    =================================================== --}}

                    <section class="smart-buy-shipment-card">

                        <div class="smart-buy-shipment-card__header">

                            <div>

                                <h2>
                                    Shipment Details
                                </h2>

                                <p>
                                    Enter the carrier and shipment information.
                                </p>

                            </div>

                        </div>


                        <div class="smart-buy-shipment-card__body">

                            <div class="smart-buy-shipment-grid smart-buy-shipment-grid--two">

                                <div class="smart-buy-shipment-field">

                                    <label for="carrier">

                                        Shipping Carrier

                                        <span>*</span>

                                    </label>

                                    <select
                                        id="carrier"
                                        name="carrier"
                                        required
                                    >

                                        <option value="">
                                            Select carrier
                                        </option>

                                        <option value="dhl">
                                            DHL
                                        </option>

                                        <option value="fedex">
                                            FedEx
                                        </option>

                                        <option value="ups">
                                            UPS
                                        </option>

                                        <option value="maersk">
                                            Maersk
                                        </option>

                                        <option value="aramex">
                                            Aramex
                                        </option>

                                        <option value="other">
                                            Other
                                        </option>

                                    </select>

                                </div>


                                <div class="smart-buy-shipment-field">

                                    <label for="tracking_number">

                                        Tracking Number

                                        <span>*</span>

                                    </label>

                                    <input
                                        type="text"
                                        id="tracking_number"
                                        name="tracking_number"
                                        placeholder="Enter tracking number"
                                        required
                                    >

                                </div>

                            </div>


                            <div class="smart-buy-shipment-grid smart-buy-shipment-grid--two">

                                <div class="smart-buy-shipment-field">

                                    <label for="shipment_date">

                                        Shipment Date

                                        <span>*</span>

                                    </label>

                                    <input
                                        type="date"
                                        id="shipment_date"
                                        name="shipment_date"
                                        value="2026-08-16"
                                        required
                                    >

                                </div>


                                <div class="smart-buy-shipment-field">

                                    <label for="estimated_delivery">

                                        Estimated Delivery

                                    </label>

                                    <input
                                        type="date"
                                        id="estimated_delivery"
                                        name="estimated_delivery"
                                    >

                                </div>

                            </div>


                            <div class="smart-buy-shipment-grid smart-buy-shipment-grid--three">

                                <div class="smart-buy-shipment-field">

                                    <label for="shipping_method">

                                        Shipping Method

                                    </label>

                                    <select
                                        id="shipping_method"
                                        name="shipping_method"
                                    >

                                        <option value="">
                                            Select method
                                        </option>

                                        <option value="air">
                                            Air Freight
                                        </option>

                                        <option value="sea">
                                            Sea Freight
                                        </option>

                                        <option value="express">
                                            Express
                                        </option>

                                        <option value="standard">
                                            Standard
                                        </option>

                                    </select>

                                </div>


                                <div class="smart-buy-shipment-field">

                                    <label for="package_count">

                                        Packages

                                    </label>

                                    <input
                                        type="number"
                                        id="package_count"
                                        name="package_count"
                                        value="1"
                                        min="1"
                                    >

                                </div>


                                <div class="smart-buy-shipment-field">

                                    <label for="weight">

                                        Total Weight

                                    </label>

                                    <div class="smart-buy-shipment-unit-input">

                                        <input
                                            type="number"
                                            id="weight"
                                            name="weight"
                                            min="0"
                                            step="0.01"
                                            placeholder="0.00"
                                        >

                                        <span>kg</span>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </section>



                    {{-- ==================================================
                    | Origin
                    =================================================== --}}

                    <section class="smart-buy-shipment-card">

                        <div class="smart-buy-shipment-card__header">

                            <div>

                                <h2>
                                    Origin Address
                                </h2>

                                <p>
                                    Where the shipment is being dispatched from.
                                </p>

                            </div>

                        </div>


                        <div class="smart-buy-shipment-card__body">

                            <div class="smart-buy-shipment-grid smart-buy-shipment-grid--two">

                                <div class="smart-buy-shipment-field">

                                    <label for="origin_name">
                                        Sender / Warehouse
                                    </label>

                                    <input
                                        type="text"
                                        id="origin_name"
                                        name="origin_name"
                                        placeholder="Warehouse or supplier name"
                                    >

                                </div>


                                <div class="smart-buy-shipment-field">

                                    <label for="origin_phone">
                                        Contact Number
                                    </label>

                                    <input
                                        type="text"
                                        id="origin_phone"
                                        name="origin_phone"
                                        placeholder="Phone number"
                                    >

                                </div>

                            </div>


                            <div class="smart-buy-shipment-field">

                                <label for="origin_address">

                                    Address

                                    <span>*</span>

                                </label>

                                <textarea
                                    id="origin_address"
                                    name="origin_address"
                                    rows="4"
                                    placeholder="Enter origin address..."
                                    required
                                ></textarea>

                            </div>


                            <div class="smart-buy-shipment-grid smart-buy-shipment-grid--three">

                                <div class="smart-buy-shipment-field">

                                    <label for="origin_city">
                                        City
                                    </label>

                                    <input
                                        type="text"
                                        id="origin_city"
                                        name="origin_city"
                                        placeholder="City"
                                    >

                                </div>


                                <div class="smart-buy-shipment-field">

                                    <label for="origin_country">
                                        Country
                                    </label>

                                    <input
                                        type="text"
                                        id="origin_country"
                                        name="origin_country"
                                        placeholder="Country"
                                    >

                                </div>


                                <div class="smart-buy-shipment-field">

                                    <label for="origin_zip">
                                        ZIP / Postal Code
                                    </label>

                                    <input
                                        type="text"
                                        id="origin_zip"
                                        name="origin_zip"
                                        placeholder="ZIP code"
                                    >

                                </div>

                            </div>

                        </div>

                    </section>



                    {{-- ==================================================
                    | Destination
                    =================================================== --}}

                    <section class="smart-buy-shipment-card">

                        <div class="smart-buy-shipment-card__header">

                            <div>

                                <h2>
                                    Delivery Address
                                </h2>

                                <p>
                                    Customer's delivery destination.
                                </p>

                            </div>

                        </div>


                        <div class="smart-buy-shipment-card__body">

                            <div class="smart-buy-shipment-recipient">

                                <div class="smart-buy-shipment-recipient__icon">

                                    <i class="ri-user-3-line"></i>

                                </div>


                                <div>

                                    <span>Recipient</span>

                                    <strong>
                                        John Doe
                                    </strong>

                                    <small>
                                        +224 600 000 000
                                    </small>

                                </div>

                            </div>


                            <div class="smart-buy-shipment-field">

                                <label for="destination_address">

                                    Address

                                    <span>*</span>

                                </label>

                                <textarea
                                    id="destination_address"
                                    name="destination_address"
                                    rows="4"
                                    required
                                >24 Rue de Paris, Conakry</textarea>

                            </div>


                            <div class="smart-buy-shipment-grid smart-buy-shipment-grid--three">

                                <div class="smart-buy-shipment-field">

                                    <label for="destination_city">
                                        City
                                    </label>

                                    <input
                                        type="text"
                                        id="destination_city"
                                        name="destination_city"
                                        value="Conakry"
                                    >

                                </div>


                                <div class="smart-buy-shipment-field">

                                    <label for="destination_country">
                                        Country
                                    </label>

                                    <input
                                        type="text"
                                        id="destination_country"
                                        name="destination_country"
                                        value="Guinea"
                                    >

                                </div>


                                <div class="smart-buy-shipment-field">

                                    <label for="destination_zip">
                                        ZIP / Postal Code
                                    </label>

                                    <input
                                        type="text"
                                        id="destination_zip"
                                        name="destination_zip"
                                        value="001"
                                    >

                                </div>

                            </div>

                        </div>

                    </section>



                    {{-- ==================================================
                    | Tracking
                    =================================================== --}}

                    <section class="smart-buy-shipment-card">

                        <div class="smart-buy-shipment-card__header">

                            <div>

                                <h2>
                                    Tracking Information
                                </h2>

                                <p>
                                    Information that will be visible to the customer.
                                </p>

                            </div>

                        </div>


                        <div class="smart-buy-shipment-card__body">

                            <div class="smart-buy-shipment-field">

                                <label for="tracking_url">
                                    Tracking URL
                                </label>

                                <input
                                    type="url"
                                    id="tracking_url"
                                    name="tracking_url"
                                    placeholder="https://carrier.com/track/..."
                                >

                            </div>


                            <div class="smart-buy-shipment-field">

                                <label for="shipment_notes">
                                    Shipment Notes
                                </label>

                                <textarea
                                    id="shipment_notes"
                                    name="shipment_notes"
                                    rows="5"
                                    maxlength="1500"
                                    placeholder="Add shipment notes for the customer..."
                                ></textarea>


                                <div class="smart-buy-shipment-field-footer">

                                <span>
                                    This information may be visible to the customer.
                                </span>

                                    <span id="shipmentNotesCount">
                                    0 / 1500
                                </span>

                                </div>

                            </div>


                            <label class="smart-buy-shipment-checkbox">

                                <input
                                    type="checkbox"
                                    name="notify_customer"
                                    value="1"
                                    checked
                                >

                                <span class="smart-buy-shipment-checkbox__box"></span>

                                <span>
                                Notify customer about the shipment.
                            </span>

                            </label>

                        </div>

                    </section>



                    {{-- ==================================================
                    | Shipment Status
                    =================================================== --}}

                    <section class="smart-buy-shipment-card">

                        <div class="smart-buy-shipment-card__header">

                            <div>

                                <h2>
                                    Shipment Status
                                </h2>

                                <p>
                                    Set the initial shipment status.
                                </p>

                            </div>

                        </div>


                        <div class="smart-buy-shipment-card__body">

                            <div class="smart-buy-shipment-field">

                                <label for="shipment_status">
                                    Status
                                </label>

                                <select
                                    id="shipment_status"
                                    name="shipment_status"
                                >

                                    <option value="preparing">
                                        Preparing
                                    </option>

                                    <option value="in_transit">
                                        In Transit
                                    </option>

                                    <option value="arrived">
                                        Arrived
                                    </option>

                                </select>

                            </div>


                            <div class="smart-buy-shipment-status-note">

                                <i class="ri-information-line"></i>

                                <p>
                                    After creating the shipment, the customer will be
                                    able to track this request from their Smart Buy
                                    tracking page.
                                </p>

                            </div>

                        </div>

                    </section>

                </div>



                {{-- ==================================================
                | Sidebar
                =================================================== --}}

                <aside class="smart-buy-shipment-sidebar">


                    {{-- Shipment Summary --}}
                    <section class="smart-buy-shipment-card">

                        <div class="smart-buy-shipment-card__header">

                            <div>

                                <h2>
                                    Shipment Summary
                                </h2>

                            </div>

                        </div>


                        <div class="smart-buy-shipment-summary">

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
                                    MacBook Pro
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
                                Destination
                            </span>

                                <strong>
                                    Conakry, Guinea
                                </strong>

                            </div>

                        </div>

                    </section>



                    {{-- Tracking Preview --}}
                    <section class="smart-buy-shipment-card">

                        <div class="smart-buy-shipment-card__header">

                            <div>

                                <h2>
                                    Customer Tracking
                                </h2>

                                <p>
                                    Initial status
                                </p>

                            </div>

                        </div>


                        <div class="smart-buy-shipment-tracking-preview">

                            <div class="smart-buy-shipment-tracking-line">

                                <div class="smart-buy-shipment-tracking-dot is-active">
                                    <i class="ri-check-line"></i>
                                </div>

                                <div>

                                    <strong>
                                        Shipment Created
                                    </strong>

                                    <span>
                                    Shipment information added
                                </span>

                                </div>

                            </div>


                            <div class="smart-buy-shipment-tracking-line">

                                <div class="smart-buy-shipment-tracking-dot">
                                    <i class="ri-truck-line"></i>
                                </div>

                                <div>

                                    <strong>
                                        In Transit
                                    </strong>

                                    <span>
                                    Waiting for shipment update
                                </span>

                                </div>

                            </div>


                            <div class="smart-buy-shipment-tracking-line">

                                <div class="smart-buy-shipment-tracking-dot">
                                    <i class="ri-home-5-line"></i>
                                </div>

                                <div>

                                    <strong>
                                        Arrived
                                    </strong>

                                    <span>
                                    Waiting for delivery
                                </span>

                                </div>

                            </div>

                        </div>

                    </section>



                    {{-- Notice --}}
                    <div class="smart-buy-shipment-notice">

                        <div class="smart-buy-shipment-notice__icon">

                            <i class="ri-information-line"></i>

                        </div>


                        <div>

                            <strong>
                                Important
                            </strong>

                            <p>
                                Make sure the tracking number is correct before
                                creating the shipment.
                            </p>

                        </div>

                    </div>

                </aside>

            </div>



            {{-- ==================================================
            | Footer
            =================================================== --}}

            <div class="smart-buy-shipment-footer">

                <div>

                <span>
                    Shipment for SB-2026-00128
                </span>

                    <small>
                        Customer: John Doe
                    </small>

                </div>


                <div class="smart-buy-shipment-footer__actions">

                    <a
                        href="{{ route('smart-buy-details', 1) }}"
                        class="smart-buy-shipment-cancel"
                        id="cancelShipment"
                    >
                        Cancel
                    </a>


                    <button
                        type="submit"
                        class="smart-buy-shipment-create"
                    >

                        <i class="ri-truck-line"></i>

                        Create Shipment

                    </button>

                </div>

            </div>

        </form>

    </div>

@endsection


@push('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const form =
                document.getElementById('smartBuyShipmentForm');

            const notes =
                document.getElementById('shipment_notes');

            const notesCount =
                document.getElementById('shipmentNotesCount');

            const shipmentDate =
                document.getElementById('shipment_date');

            const estimatedDelivery =
                document.getElementById('estimated_delivery');

            const cancelShipment =
                document.getElementById('cancelShipment');


            /*
            |--------------------------------------------------------------------------
            | Notes Counter
            |--------------------------------------------------------------------------
            */

            function updateNotesCount() {

                if (!notes || !notesCount) {
                    return;
                }

                notesCount.textContent =
                    `${notes.value.length} / ${notes.maxLength}`;

            }


            notes?.addEventListener(
                'input',
                updateNotesCount
            );

            updateNotesCount();


            /*
            |--------------------------------------------------------------------------
            | Estimated Delivery
            |--------------------------------------------------------------------------
            */

            shipmentDate?.addEventListener(
                'change',
                function () {

                    if (!estimatedDelivery) {
                        return;
                    }


                    if (
                        !estimatedDelivery.value &&
                        shipmentDate.value
                    ) {

                        const date =
                            new Date(
                                shipmentDate.value + 'T00:00:00'
                            );


                        date.setDate(
                            date.getDate() + 10
                        );


                        const year =
                            date.getFullYear();


                        const month =
                            String(
                                date.getMonth() + 1
                            ).padStart(2, '0');


                        const day =
                            String(
                                date.getDate()
                            ).padStart(2, '0');


                        estimatedDelivery.value =
                            `${year}-${month}-${day}`;

                    }

                }
            );


            /*
            |--------------------------------------------------------------------------
            | Cancel
            |--------------------------------------------------------------------------
            */

            cancelShipment?.addEventListener(
                'click',
                function (event) {

                    const confirmed =
                        window.confirm(
                            'Cancel shipment creation and return to request details?'
                        );


                    if (!confirmed) {
                        event.preventDefault();
                    }

                }
            );


            /*
            |--------------------------------------------------------------------------
            | Submit
            |--------------------------------------------------------------------------
            */

            form?.addEventListener(
                'submit',
                function (event) {

                    if (!form.checkValidity()) {

                        event.preventDefault();

                        form.reportValidity();

                        return;

                    }


                    const trackingNumber =
                        document.getElementById(
                            'tracking_number'
                        )?.value.trim();


                    if (!trackingNumber) {

                        event.preventDefault();

                        return;

                    }


                    const confirmed =
                        window.confirm(
                            `Create shipment with tracking number "${trackingNumber}"?`
                        );


                    if (!confirmed) {

                        event.preventDefault();

                        return;

                    }


                    const button =
                        form.querySelector(
                            '.smart-buy-shipment-create'
                        );


                    if (button) {

                        button.disabled = true;

                        button.innerHTML = `
                    <i class="ri-loader-4-line smart-buy-shipment-spin"></i>
                    Creating...
                `;

                    }

                }
            );

        });
    </script>

@endpush
