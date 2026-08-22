@extends('backend.layouts.backend')

@section('title', 'Create Shipment')

@section('content')

    <div class="shipment-create-page">

        {{-- ================================================================ --}}
        {{-- PAGE HEADER --}}
        {{-- ================================================================ --}}

        <div class="shipment-create-page__header">

            <div>

                <a
                    href="{{ route('ecommerce-shipments') }}"
                    class="shipment-create-back"
                >

                    <i class="ri-arrow-left-line"></i>

                    Back to Shipments

                </a>


                <span class="shipment-create-page__eyebrow">
                Ecommerce / Shipments
            </span>

                <h1>
                    Create Shipment
                </h1>

                <p>
                    Create a shipment for an ecommerce order and add tracking information.
                </p>

            </div>


            <div class="shipment-create-page__actions">

                <a
                    href="{{ route('ecommerce-shipments') }}"
                    class="shipment-create-btn shipment-create-btn--secondary"
                >

                    Cancel

                </a>


                <button
                    type="submit"
                    form="create-shipment-form"
                    class="shipment-create-btn shipment-create-btn--primary"
                >

                    <i class="ri-add-line"></i>

                    Create Shipment

                </button>

            </div>

        </div>


        {{-- ================================================================ --}}
        {{-- FORM --}}
        {{-- ================================================================ --}}

        <form
            id="create-shipment-form"
            action="#"
            method="POST"
            class="shipment-create-form"
        >

            @csrf


            {{-- ============================================================ --}}
            {{-- MAIN GRID --}}
            {{-- ============================================================ --}}

            <div class="shipment-create-grid">


                {{-- ======================================================== --}}
                {{-- LEFT COLUMN --}}
                {{-- ======================================================== --}}

                <div class="shipment-create-main">


                    {{-- ==================================================== --}}
                    {{-- ORDER INFORMATION --}}
                    {{-- ==================================================== --}}

                    <div class="shipment-create-card">

                        <div class="shipment-create-card__header">

                            <div>

                                <h2>
                                    Order Information
                                </h2>

                                <span>
                                Select the ecommerce order for this shipment.
                            </span>

                            </div>

                        </div>


                        <div class="shipment-create-card__body">

                            <div class="shipment-form-group">

                                <label for="order">

                                    Order

                                    <span>*</span>

                                </label>


                                <select
                                    id="order"
                                    name="order"
                                    required
                                >

                                    <option value="">
                                        Select an order
                                    </option>

                                    <option value="1001">
                                        #BA-1001 — John Doe — $149.97
                                    </option>

                                    <option value="1002">
                                        #BA-1002 — Sarah Miller — $89.98
                                    </option>

                                    <option value="1003">
                                        #BA-1003 — Michael Adams — $279.95
                                    </option>

                                    <option value="1004">
                                        #BA-1004 — Emma Wilson — $59.99
                                    </option>

                                    <option value="1005">
                                        #BA-1005 — David Williams — $199.96
                                    </option>

                                </select>


                                <small>
                                    Select an order that needs shipment.
                                </small>

                            </div>

                        </div>

                    </div>


                    {{-- ==================================================== --}}
                    {{-- SHIPMENT INFORMATION --}}
                    {{-- ==================================================== --}}

                    <div class="shipment-create-card">

                        <div class="shipment-create-card__header">

                            <div>

                                <h2>
                                    Shipment Information
                                </h2>

                                <span>
                                Enter carrier and tracking information.
                            </span>

                            </div>

                        </div>


                        <div class="shipment-create-card__body">

                            <div class="shipment-form-grid">


                                {{-- Carrier --}}
                                <div class="shipment-form-group">

                                    <label for="carrier">

                                        Carrier

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

                                        <option value="usps">
                                            USPS
                                        </option>

                                        <option value="other">
                                            Other
                                        </option>

                                    </select>

                                </div>


                                {{-- Tracking Number --}}
                                <div class="shipment-form-group">

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


                                {{-- Shipment Status --}}
                                <div class="shipment-form-group">

                                    <label for="shipment_status">

                                        Shipment Status

                                        <span>*</span>

                                    </label>


                                    <select
                                        id="shipment_status"
                                        name="shipment_status"
                                        required
                                    >

                                        <option value="">
                                            Select status
                                        </option>

                                        <option value="pending">
                                            Pending
                                        </option>

                                        <option value="processing">
                                            Processing
                                        </option>

                                        <option value="shipped">
                                            Shipped
                                        </option>

                                        <option value="in-transit">
                                            In Transit
                                        </option>

                                        <option value="out-for-delivery">
                                            Out for Delivery
                                        </option>

                                        <option value="delivered">
                                            Delivered
                                        </option>

                                        <option value="failed">
                                            Failed
                                        </option>

                                    </select>

                                </div>


                                {{-- Delivery Status --}}
                                <div class="shipment-form-group">

                                    <label for="delivery_status">

                                        Delivery Status

                                    </label>


                                    <select
                                        id="delivery_status"
                                        name="delivery_status"
                                    >

                                        <option value="">
                                            Select status
                                        </option>

                                        <option value="pending">
                                            Pending
                                        </option>

                                        <option value="in-transit">
                                            In Transit
                                        </option>

                                        <option value="out-for-delivery">
                                            Out for Delivery
                                        </option>

                                        <option value="delivered">
                                            Delivered
                                        </option>

                                        <option value="failed">
                                            Failed
                                        </option>

                                    </select>

                                </div>


                                {{-- Estimated Delivery --}}
                                <div class="shipment-form-group">

                                    <label for="estimated_delivery">

                                        Estimated Delivery

                                    </label>


                                    <input
                                        type="date"
                                        id="estimated_delivery"
                                        name="estimated_delivery"
                                    >

                                </div>


                                {{-- Shipment Date --}}
                                <div class="shipment-form-group">

                                    <label for="shipment_date">

                                        Shipment Date

                                    </label>


                                    <input
                                        type="date"
                                        id="shipment_date"
                                        name="shipment_date"
                                    >

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- ==================================================== --}}
                    {{-- SHIPPING ADDRESS --}}
                    {{-- ==================================================== --}}

                    <div class="shipment-create-card">

                        <div class="shipment-create-card__header">

                            <div>

                                <h2>
                                    Shipping Address
                                </h2>

                                <span>
                                Enter the destination address for the shipment.
                            </span>

                            </div>

                        </div>


                        <div class="shipment-create-card__body">

                            <div class="shipment-form-grid">


                                {{-- Full Name --}}
                                <div class="shipment-form-group">

                                    <label for="shipping_name">

                                        Full Name

                                        <span>*</span>

                                    </label>


                                    <input
                                        type="text"
                                        id="shipping_name"
                                        name="shipping_name"
                                        placeholder="Enter recipient name"
                                        required
                                    >

                                </div>


                                {{-- Phone --}}
                                <div class="shipment-form-group">

                                    <label for="shipping_phone">

                                        Phone Number

                                        <span>*</span>

                                    </label>


                                    <input
                                        type="tel"
                                        id="shipping_phone"
                                        name="shipping_phone"
                                        placeholder="Enter phone number"
                                        required
                                    >

                                </div>


                                {{-- Address --}}
                                <div class="shipment-form-group shipment-form-group--full">

                                    <label for="shipping_address">

                                        Address

                                        <span>*</span>

                                    </label>


                                    <input
                                        type="text"
                                        id="shipping_address"
                                        name="shipping_address"
                                        placeholder="Street address, apartment, suite, etc."
                                        required
                                    >

                                </div>


                                {{-- City --}}
                                <div class="shipment-form-group">

                                    <label for="shipping_city">

                                        City

                                        <span>*</span>

                                    </label>


                                    <input
                                        type="text"
                                        id="shipping_city"
                                        name="shipping_city"
                                        placeholder="Enter city"
                                        required
                                    >

                                </div>


                                {{-- State --}}
                                <div class="shipment-form-group">

                                    <label for="shipping_state">

                                        State / Province

                                    </label>


                                    <input
                                        type="text"
                                        id="shipping_state"
                                        name="shipping_state"
                                        placeholder="Enter state or province"
                                    >

                                </div>


                                {{-- Postal Code --}}
                                <div class="shipment-form-group">

                                    <label for="shipping_postal_code">

                                        Postal Code

                                        <span>*</span>

                                    </label>


                                    <input
                                        type="text"
                                        id="shipping_postal_code"
                                        name="shipping_postal_code"
                                        placeholder="Enter postal code"
                                        required
                                    >

                                </div>


                                {{-- Country --}}
                                <div class="shipment-form-group">

                                    <label for="shipping_country">

                                        Country

                                        <span>*</span>

                                    </label>


                                    <select
                                        id="shipping_country"
                                        name="shipping_country"
                                        required
                                    >

                                        <option value="">
                                            Select country
                                        </option>

                                        <option value="usa">
                                            United States
                                        </option>

                                        <option value="canada">
                                            Canada
                                        </option>

                                        <option value="uk">
                                            United Kingdom
                                        </option>

                                        <option value="australia">
                                            Australia
                                        </option>

                                        <option value="bangladesh">
                                            Bangladesh
                                        </option>

                                        <option value="other">
                                            Other
                                        </option>

                                    </select>

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- ==================================================== --}}
                    {{-- SHIPMENT NOTES --}}
                    {{-- ==================================================== --}}

                    <div class="shipment-create-card">

                        <div class="shipment-create-card__header">

                            <div>

                                <h2>
                                    Shipment Notes
                                </h2>

                                <span>
                                Add any internal notes related to this shipment.
                            </span>

                            </div>

                        </div>


                        <div class="shipment-create-card__body">

                            <div class="shipment-form-group">

                                <label for="notes">
                                    Notes
                                </label>


                                <textarea
                                    id="notes"
                                    name="notes"
                                    rows="5"
                                    placeholder="Enter shipment notes..."
                                ></textarea>

                            </div>

                        </div>

                    </div>


                </div>


                {{-- ======================================================== --}}
                {{-- RIGHT SIDEBAR --}}
                {{-- ======================================================== --}}

                <div class="shipment-create-sidebar">


                    {{-- ==================================================== --}}
                    {{-- STATUS --}}
                    {{-- ==================================================== --}}

                    <div class="shipment-create-card">

                        <div class="shipment-create-card__header">

                            <h2>
                                Shipment Status
                            </h2>

                        </div>


                        <div class="shipment-create-card__body">

                            <div class="shipment-status-preview">

                                <div class="shipment-status-preview__icon">

                                    <i class="ri-truck-line"></i>

                                </div>


                                <div>

                                    <strong>
                                        New Shipment
                                    </strong>

                                    <span>
                                    Shipment has not been created yet.
                                </span>

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- ==================================================== --}}
                    {{-- ORDER PREVIEW --}}
                    {{-- ==================================================== --}}

                    <div class="shipment-create-card">

                        <div class="shipment-create-card__header">

                            <h2>
                                Order Preview
                            </h2>

                        </div>


                        <div class="shipment-order-preview">


                            <div class="shipment-order-preview__top">

                                <div class="shipment-order-preview__icon">

                                    <i class="ri-shopping-bag-3-line"></i>

                                </div>


                                <div>

                                    <strong>
                                        #BA-1001
                                    </strong>

                                    <span>
                                    John Doe
                                </span>

                                </div>

                            </div>


                            <div class="shipment-order-preview__details">


                                <div>

                                <span>
                                    Items
                                </span>

                                    <strong>
                                        3
                                    </strong>

                                </div>


                                <div>

                                <span>
                                    Order Total
                                </span>

                                    <strong>
                                        $149.97
                                    </strong>

                                </div>


                                <div>

                                <span>
                                    Payment
                                </span>

                                    <strong class="shipment-order-paid">
                                        Paid
                                    </strong>

                                </div>

                            </div>


                            <a
                                href="{{ route('admin-order-details', ['order' => 1001]) }}"
                                class="shipment-order-view"
                            >

                                View Order

                                <i class="ri-arrow-right-line"></i>

                            </a>

                        </div>

                    </div>


                    {{-- ==================================================== --}}
                    {{-- QUICK INFO --}}
                    {{-- ==================================================== --}}

                    <div class="shipment-create-card">

                        <div class="shipment-create-card__header">

                            <h2>
                                Shipment Checklist
                            </h2>

                        </div>


                        <div class="shipment-checklist">


                            <div>

                                <i class="ri-checkbox-circle-line"></i>

                                <span>
                                Select an order
                            </span>

                            </div>


                            <div>

                                <i class="ri-checkbox-circle-line"></i>

                                <span>
                                Add carrier
                            </span>

                            </div>


                            <div>

                                <i class="ri-checkbox-circle-line"></i>

                                <span>
                                Add tracking number
                            </span>

                            </div>


                            <div>

                                <i class="ri-checkbox-circle-line"></i>

                                <span>
                                Set shipment status
                            </span>

                            </div>


                            <div>

                                <i class="ri-checkbox-circle-line"></i>

                                <span>
                                Confirm delivery address
                            </span>

                            </div>

                        </div>

                    </div>


                </div>

            </div>

        </form>

    </div>

@endsection
